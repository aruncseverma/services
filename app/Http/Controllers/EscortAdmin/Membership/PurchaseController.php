<?php
/**
 * controls the transaction for purchasing
 * a membership plan
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Membership;

use App\Events\Admin\Notification\NotifyAdmin;
use App\Notifications\EscortAdmin\Membership\VipInvoiceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{

    /**
     * Displays the available VIP Plans
     *
     * @return View
     */
    public function index()
    {
        $this->setTitle(__('VIP Subscription'));

        $billers = $this->billerRepository->getAllActive();
        $plans = $this->repository->getAllActive();
        $user = $this->getAuthUser();

        return view('EscortAdmin::membership.form', [
            'plans'     => $plans,
            'billers'   => $billers
        ]);
    }

    /**
     * API
     * Api function for purchasing
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function purchase(Request $request)
    {
        $this->validateRequest($request);

        $sendInvoice = false;

        $params = [
            'user_id'       => $this->getAuthUser()->id,
            'plan_id'       => $request->plan_id,
            'duration'      => $request->duration,
            'payment_id'    => $request->biller_id,
            'status'        => $request->status
        ];

        $total = $this->vipRepository->getLastInserted();
        $currDate = date('Ymd');
        $orderId = $currDate . '-' . sprintf('%05d', $total + 1);

        if ($request->status == 'C') {
            $params['date_paid'] = Carbon::now();
            $params['order_id'] = $request->payment_details;
        } else {
            $params['order_id'] = $orderId;
            $sendInvoice = true;
        }

        $user = $this->getAuthUser();
        $biller = $this->billerRepository->find($request->biller_id);
        $plan = $this->repository->find($request->plan_id);

        $result = $this->vipRepository->store($params, $user, $plan, $biller, null);
        
        // Notify Admin that someone purchased a VIP Plan
        $name = $user->name;
        $duration = $request->duration;
        $message = "$name purchased a $duration VIP Plan.";
        event(new NotifyAdmin($message));

        // Modify email notification
        if ($result && $sendInvoice) {
            if($request->biller_id == 1) {
                $message = "You may send the wire transfer to our bank";
            } else {
                $message = "You may pay us through the nearest Western Union office.";
            }

            $user->notify(new VipInvoiceNotification($biller, $message, $plan->total_amount, $orderId));
        }

        return json_encode($result->toArray());
    }

    /**
     * Handles input validation
     *
     * @param Request $request
     * @return void
     */
    public function validateRequest(Request $request)
    {
        $this->validate(
            $request,
            [
                'plan_id'   => 'required|integer',
                'duration'  => 'required|integer',
                'biller_id'=> 'required|integer',
            ]
        );
    }
}
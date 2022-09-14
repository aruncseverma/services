<?php
/**
 * Contains Vip requests from escorts
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Admin\Finance;

use App\Events\EscortAdmin\Notification\NotifyEscort;
use App\Events\EscortAdmin\Notification\WarnEscort;
use App\Repository\VipMembershipRepository;
use App\Support\Concerns\NeedsStorage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VipTransactionController extends Controller
{
    use NeedsStorage;
    /**
     * Undocumented function
     *
     * @param VipMembershipRepository $repo
     * @return void
     */
    public function index(VipMembershipRepository $repo)
    {
        $this->setTitle(__('Vip Requests'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'is_active' => '*',
                'status' => '*',
                'user' => '*'
            ],
            $this->request->query()
        );

        $purchases = $repo->search($limit, $search);

        foreach ($purchases as $purchase) {
            if (isset($purchase->payment) || !empty($purchase->payment)) {
                $storage =  $this->getStorage()->disk('invoice');
                $path = $purchase->payment->attachment;

                $img = $storage->get($path);
                $mime = $storage->mimeType($path);

                $attachment = [
                    'image' => base64_encode($img),
                    'mime' => $mime
                ];

                $purchase->payment->attachment = $attachment;
            }
        }

        return view('Admin::finance.purchases', [
            'purchases' => $purchases,
            'search'    => $search
        ]);
    }

    /**
     * Updates the status of the purchased VIP Services
     *
     * @param integer $id
     * @param VipMembershipRepository $repo
     *
     * @return void
     */
    public function updateStatus(int $id, VipMembershipRepository $repo)
    {
        $param = $this->request->all();
        $plan = $repo->find($id);

        if (isset($param['vip_status']) && $param['vip_status'] == 'A') {
            $param['expiration_date'] = Carbon::now()->addMonths($plan->duration);
        }

        $query = $repo->updateStatus($param, $id);

        // notify
        $this->handleNotifications($plan->user_id, $param);
        $this->notifySuccess(__('Transaction updated successfully.'));

        return back();
    }

    /**
     * Handles pop up notifications sent to the user
     *
     * @param array $request
     * @return void
     */
    public function handleNotifications($id, array $request)
    {
        $status = isset($request['status']) ? $request['status'] : '';
        $vipStatus = isset($request['vip_status']) ? $request['vip_status'] : '';

        $mode = 1;
        $message = "";

        if ($vipStatus == 'A') {
            $mode = 1;
            $message = "<b>Congratulations: </b> You are now a VIP Member!";
        } else if ($status == 'C') {
            $mode = 1;
            $message = "<b>Head's up! Your VIP request is being processed.</b>";
        } else if ($vipStatus == 'D') {
            $mode = 0;
            $message = "<b>Uh-oh!</b> Admin rejected your request for VIP Member";
        } else if ($vipStatus == 'R') {
            $mode = 0;
            $message = "<b>Oh no!</b> Admin revoked your VIP membership. Please check your email for reason";
        } else {
            $mode = 0;
            $message = "<b>Oh no!</b> Something went wrong with your request. Please try again.";
        }

        if ($mode == 1) {
            event(new NotifyEscort($id, $message));
        } else {
            event(new WarnEscort($id, $message));
        }
    }
}
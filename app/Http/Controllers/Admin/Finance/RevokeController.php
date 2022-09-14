<?php
/**
 * handles revokation of vip membership
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\Finance\Controller;
use App\Notifications\Admin\Plans\RevokeVip;
use App\Repository\EscortRepository;
use App\Repository\RevokeMembershipRepository;
use App\Repository\VipMembershipRepository;
use Illuminate\Http\Request;

class RevokeController extends Controller
{
    public function handle(Request $request, VipMembershipRepository $membershipRepo, RevokeMembershipRepository $repo)
    {
        $this->validateRequest($request);

        $response = [
            'code' => 1,
            'message' => __('Success')
        ];

        $userRepo = app(EscortRepository::class);

        $param = $request->all();
        $admin = $this->getAuthUser();
        $plan = $membershipRepo->fetch($param['transaction_id']);
        $escort = $userRepo->find($plan->user_id);

        $result = $repo->store($param, $admin, $plan, null);

        if (!$result) {
            $response['code'] = 0;
            $response['message'] = __('Failed');
        } else {
             // notify user
            $escort->notify(new RevokeVip($admin->name, $param['reason'], $plan->order_id));
        }

        return json_encode($response);
    }
    /**
     * Validates user input
     *
     * @param Request $request
     * @return void
     */
    private function validateRequest(Request $request)
    {
        $this->validate(
            $request,
            [
                'reason' => 'required',
                'transaction_id' => 'required'
            ]
        );
    }
}
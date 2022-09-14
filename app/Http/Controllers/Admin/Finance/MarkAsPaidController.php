<?php
/**
 * Handles payment process for VIP Membership Plan
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\Admin\Finance;

use App\Repository\PlanPaymentRepository;
use App\Repository\VipMembershipRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MarkAsPaidController extends Controller
{
    /**
     * handles user request
     *
     * @param Request $request
     * @param PlanPaymentRepository $repo
     * @param VipMembershipRepository $membershipRepo
     * @return void
     */
    public function handle(Request $request, PlanPaymentRepository $repo, VipMembershipRepository $membershipRepo)
    {
        $this->validateRequest($request);

        $response = [
            'code' => 1,
            'message' => __('Success')
        ];

        $approver = $this->getAuthUser();
        $membershipRepo = $membershipRepo->find($request->trans_id);
        if ($path = $this->storeUploadedFile($request->file('attachment'))) {
            $params = [
                'trans_id' => $request->trans_id,
                'reference_id' => $request->reference_id,
                'attachment' => $path
            ];

            $result = $repo->store($params, $approver, $membershipRepo, null);

            if (!$result) {
                $response['code'] = 0;
                $response['message'] = __('Failed');
            }
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
                'trans_id' => 'required',
                'reference_id' => 'required',
                'attachment' => 'mimes:jpeg,bmp,png,jpg,pdf'
            ]
        );
    }

    /**
     * store uploaded payment invoice
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|false
     */
    protected function storeUploadedFile(UploadedFile $file)
    {
        $options['visibility'] = 'private';
        return $file->store(null, 'invoice');
    }
}
<?php
/**
 * updates current agency newsletter subscription setting
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\AccountSettings;

use Illuminate\Http\Request;
use App\Repository\AgencyRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Events\AgencyAdmin\AccountSettings\ChangedNewsletterSetting;

class UpdateNewsletterSubscriptionController extends Controller
{
    /**
     * repository instance
     *
     * @var App\Repository\AgencyRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\AgencyRepository $repository
     */
    public function __construct(AgencyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handles incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request) : Response
    {
        $this->validateRequest($request);

        // update
        $agency = $this->repository->save(
            [
                'is_newsletter_subscriber' => $request->input('is_subscribed')
            ],
            $this->getAuthUser()
        );

        // notify successful update
        $this->notifySuccess(__('Newsletter subscription setting updated successfully'));

        /**
         * trigger event
         *
         * @param App\Models\Agency
         */
        event(new ChangedNewsletterSetting($agency));

        return back()->withInput(['notify' => 'newsletter_setting']);
    }

    /**
     * validates incoming request data
     *
     * @throws Illuminate\Validation\ValidationException
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'is_subscribed' => 'boolean'
            ]
        );
    }
}

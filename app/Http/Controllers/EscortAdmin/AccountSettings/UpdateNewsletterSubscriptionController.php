<?php
/**
 * updates current escort newsletter subscription setting
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use Illuminate\Http\Request;
use App\Repository\EscortRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Events\EscortAdmin\AccountSettings\ChangedNewsletterSetting;

class UpdateNewsletterSubscriptionController extends Controller
{
    /**
     * repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\EscortRepository $repository
     */
    public function __construct(EscortRepository $repository)
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
        $escort = $this->repository->save(
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
         * @param App\Models\Escort
         */
        event(new ChangedNewsletterSetting($escort));

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

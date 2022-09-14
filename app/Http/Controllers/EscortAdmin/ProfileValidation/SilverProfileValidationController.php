<?php
/**
 * controller class for handling silver validation process
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\ProfileValidation;

use App\Events\Admin\Notification\NotifyAdmin;
use App\Models\Administrator;
use App\Models\Escort;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\UserProfileValidation;
use App\Notifications\Admin\ProfileValidation\NewValidation;
use Illuminate\Http\RedirectResponse;
use App\Support\Concerns\NeedsStorage;
use App\Repository\UserGroupRepository;
use App\Repository\UserProfileValidationRepository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Exceptions\HttpResponseException;

class SilverProfileValidationController extends Controller
{
    use NeedsStorage;

    /**
     * repository instance
     *
     * @var App\Repository\UserProfileValidationRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\UserProfileValidationRepository $repository
     */
    public function __construct(UserProfileValidationRepository $repository)
    {
        $this->repository = $repository;

        // call parent constructor
        parent::__construct();
    }

    /**
     * handles incoming request data
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        // validate request data
        $this->validateRequest($request);

        // validate membership information
        $this->validateMembershipInformation($escort = $this->getAuthUser());

        // store first file to storage
        if ($path = $this->storeUploadedMugShot($request->file('mug_shot_file'))) {
            // store path and bind to current user
            $group = app(UserGroupRepository::class)->find(UserGroup::SILVER_GROUP_ID);
            $data = [
                $this->getDiskNameForMugShots() . '_path' => $path,
            ];

            // save
            if (! $this->saveUserProfileValidation($data, $escort, $group)) {
                $this->notifyError(__('Unable to save membership request. Please try again sometime'));
                return $this->redirectTo();
            }

            // notify admin
            $name = $escort->name;
            $message = "<b>$name</b> sent an image for Silver Member Validation.";
            event(new NotifyAdmin($message));

            Administrator::find(1)->get()->notify(new NewValidation($escort->name));

            // success
            $this->notifySuccess(__('Membership validation request was successfully saved. Please wait for the approval of your request'));
        } else {
            // failed to upload photo
            $this->notifyError(__('Unable to upload your requirements. Please try again sometime'));
        }

        return $this->redirectTo();
    }

    /**
     * validate request data
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
                'mug_shot_file' => 'required|image|max:3000|dimensions:max_width=1200|mimes:jpeg,jpg'
            ]
        );
    }

    /**
     * validates membership information
     *
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     *
     * @param  App\Models\Escort $escort
     *
     * @return void
     */
    protected function validateMembershipInformation(Escort $escort) : void
    {
        $escort = $this->getAuthUser();
        $groupId = optional($escort->userGroup)->getKey();

        // validate user membership first
        if ($groupId === UserGroup::SILVER_GROUP_ID) {
            $this->notifyError(__('You already validated as a silver member'));
        } elseif ($groupId === UserGroup::GOLD_GROUP_ID) {
            $this->notifyError(__('You already validated as a gold member'));
        } else {
            return;
        }

        throw new HttpResponseException($this->redirectTo());
    }

    /**
     * store uploaded mugshot
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|false
     */
    protected function storeUploadedMugShot(UploadedFile $file)
    {
        return $file->store(null, $this->getDiskNameForMugShots());
    }

    /**
     * save membership request information
     *
     * @param  array                $data
     * @param  App\Models\Escort    $escort
     * @param  App\Models\UserGroup $userGroup
     *
     * @return App\Models\UserProfileValidation|null
     */
    protected function saveUserProfileValidation(array $data, Escort $escort, UserGroup $userGroup) : ?UserProfileValidation
    {
        if (empty($data)) {
            return null;
        }

        // save information
        $request = $this->repository->store(
            [
                'data' => $data,
                'is_approved' => false,
                'is_denied' => false,
            ],
            $escort,
            $userGroup
        );

        return $request;
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return redirect()->back()->withInput(['notify' => 'membership.silver']);
    }
}

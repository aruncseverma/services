<?php
/**
 * controller class for profile validation for gold membership
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

class GoldProfileValidationController extends Controller
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
     * handles incoming request
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

        if ($path = $this->storeUploadedPhotoId($request->file('photo_id_file'))) {
            $group = app(UserGroupRepository::class)->find(UserGroup::GOLD_GROUP_ID);

            // parse
            $data = [
                $this->getDiskNameForPrivatePhotoId() . '_path' => $path,
                'info' => $this->encryptInformationFromRequest($request),
            ];

            // save
            if (! $this->saveUserProfileValidation($data, $escort, $group)) {
                $this->notifyError(__('Unable to save membership request. Please try again sometime'));
                return $this->redirectTo();
            }

            // notify admin
            $name = $escort->name;
            $message = "<b>$name</b> sent an image for Gold Member Validation.";
            event(new NotifyAdmin($message));

            // Notify Administrators
            Administrator::find(1)->notify(new NewValidation($escort->name));

            // success
            $this->notifySuccess(__('Membership validation request was successfully saved. Please wait for the approval of your request'));
        } else {
            $this->notifyError(__('Unable to upload your photo. Please try again sometime'));
        }

        return $this->redirectTo();
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
                'photo_id_file' => 'required|image|max:3000|dimensions:max_width=1200|mimes:jpeg,jpg',
                'private.name' => 'required',
                'private.birthdate' => 'required|date',
                'private.tel' => 'required',
                'private.email' => 'required|email',
                'private.emergency_tel' => 'required',
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
        if ($groupId !== UserGroup::SILVER_GROUP_ID) {
            $this->notifyError(__('You must have a valid silver membership. Please validate first your account to silver membership'));
        } elseif ($groupId === UserGroup::GOLD_GROUP_ID) {
            $this->notifyError(__('You already validated as a gold member'));
        } else {
            return;
        }

        throw new HttpResponseException($this->redirectTo());
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
     * store uploaded photo id
     *
     * @param  Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    protected function storeUploadedPhotoId(UploadedFile $file) : ?string
    {
        return $file->store(null, $this->getDiskNameForPrivatePhotoId());
    }

    /**
     * encrypt private information from request object
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function encryptInformationFromRequest(Request $request) : string
    {
        return encrypt(
            json_encode([
                'name' => $request->input('private.name'),
                'email' => $request->input('private.email'),
                'birthdate' => $request->input('private.birthdate'),
                'tel' => $request->input('private.tel'),
                'emergency_tel' => $request->input('private.emergency_tel'),
            ])
        );
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return redirect()->back()->withInput(['notify' => 'membership.gold']);
    }
}

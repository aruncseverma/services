<?php
/**
 * controller class for approving profile validation request
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\ProfileValidation;

use App\Events\EscortAdmin\Notification\NotifyEscort;
use App\Models\User;
use App\Models\UserGroup;
use App\Repository\UserRepository;
use App\Models\UserProfileValidation;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;
use App\Repository\UserProfileValidationRepository;
use App\Support\Concerns\EscortFilterCache;

class ApproveController extends Controller
{
    use EscortFilterCache;

    /**
     * escort repository instance
     *
     * @var App\Repository\EscortRepository
     */
    protected $userRepository;

    /**
     * create instance
     *
     * @param App\Repository\UserRepository                  $userRepository
     * @param App\Repository\UserProfileValidationRepository $requestRepository
     */
    public function __construct(UserRepository $userRepository, UserProfileValidationRepository $requestRepository)
    {
        $this->userRepository = $userRepository;

        // call parent constructor
        parent::__construct($requestRepository);
    }

    /**
     * handle incoming request
     *
     * @param  App\Models\UserProfileValidation $model
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(UserProfileValidation $model) : RedirectResponse
    {
        // updates the current user group
        $user = $this->updateUserUserGroup($model->user, $model->userGroup);
        $level = 0;

        // process per user group action
        // @todo should check from relation model key defined
        if ($user->wasChanged('user_group_id')) {
            switch ($model->userGroup->getKey()) {
                case UserGroup::SILVER_GROUP_ID:
                    // do nothing for this user group
                    break;
                case UserGroup::GOLD_GROUP_ID:
                    $user = $this->setUserPrivateInformation($model->data, $user);
                    $level = 1;
                    break;
            }

            // update model to approved
            $this->repository->save(['is_approved' => true], $model);

            // send notification
            $user->sendApprovedProfileValidationNotification();

            // notify
            $userLevel = ($level == 0) ? 'Silver' : 'Gold';
            $message = "<b>Success</b> you are now a $userLevel Member";
            event(new NotifyEscort($user->getKey(), $message));
            $this->notifySuccess(__('Profile validation approved successfully'));
            $this->removeEscortFilterCache('verification');
        } else {
            $this->notifyWarning(__('No changes detected. Please select another one'));
        }

        return back();
    }

    /**
     * update current user user group
     *
     * @param  App\Models\User      $user
     * @param  App\Models\UserGroup $group
     *
     * @return App\Models\User
     */
    protected function updateUserUserGroup(User $user, UserGroup $group) : User
    {
        return $this->userRepository->setUserGroup($user, $group);
    }

    /**
     * set user private information
     *
     * @param  array           $data
     * @param  App\Models\User $user
     *
     * @return App\Models\User
     */
    protected function setUserPrivateInformation(array $data, User $user) : User
    {
        if (! isset($data['info'])) {
            return $user;
        }

        // get user data repository
        $userDataRepository = app(UserDataRepository::class);

        // sets private information (saves as unencrypted text)
        $userDataRepository->create(['field' => 'private', 'content' => $data['info']], $user);

        return $user;
    }
}

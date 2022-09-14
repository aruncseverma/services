<?php
/**
 * controller class for creating new language proficiency of escort
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortLanguageRepository;

class AddLanguageProficiencyController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        if (! $user) {
            $this->notifyError(__('User not found.'));
            return redirect()->back();
        }

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save user
        $user = $this->saveUser($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'add_language');
            $this->removeEscortFilterCache('lang_ids'); // [F] advanced filter > languages filter
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }
        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Escort|null $user
     *
     * @return void
     */
    protected function validateRequest(Escort $user = null) : void
    {
        $rules = [
            'language_proficiency.language' => ['required'],
            'language_proficiency.proficiency' => ['required'],
        ];

        $messages = [
            'language_proficiency.language' => 'The Language field is required.',
            'language_proficiency.proficiency' => 'The Proficiency field is required.',
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules,
            $messages
        );
    }

    /**
     * save user data
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function saveUser(Escort $user = null) : Escort
    {
        // save escort language
        $this->saveEscortLanguage($user);

        return $user;
    }

    /**
     * save escort language
     *
     * @param  App\Models\Escort $user
     *
     * @return void
     */
    protected function saveEscortLanguage(Escort $user) : void
    {

        $repository = app(EscortLanguageRepository::class);
        $data = $this->request->input('language_proficiency');

        // gets previously set
        $row = $repository->findEscortLanguageByAttributeId($data['language'], $user);

        // save it
        $repository->store(
            [
                'attribute_id' => $data['language'],
                'proficiency' => $data['proficiency'],
            ],
            $user,
            $row
        );
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\Escort $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Escort $user) : RedirectResponse
    {
        return redirect()->route('escort_admin.profile');
    }
}

<?php
/**
 * controller class for deleting escort language proficiency
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Profile;

use App\Models\Escort;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortLanguageRepository;

class DeleteLanguageProficiencyController extends Controller
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

        // delete escort language
        $user = $this->deleteLanguage($user);

        // notify next request
        if ($user) {
            $this->notifySuccess(__('Data successfully saved.'));
            $this->addUserActivity(self::ACTIVITY_TYPE, $user->getKey(), 'delete_language');
        } else {
            $this->notifyWarning(__('Unable to save current request. Please try again sometime'));
        }
        return $this->redirectTo($user);
    }

    /**
     * delete escort language
     *
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function deleteLanguage(Escort $user = null) : Escort
    {
        $repository = app(EscortLanguageRepository::class);
        $languageId = $this->request->input('id');

        // gets previously set
        $data = $repository->findEscortLanguageByAttributeId($languageId, $user);

        // if has model set delete that
        if ($data) {
            $repository->delete($data->getKey());
        }

        return $user;
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

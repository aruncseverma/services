<?php
/**
 * Handles email viewing and decrypting
 *
 * @author Jhay Bagas <bagas.jhay@email.com>
 */
namespace App\Http\Controllers\EscortAdmin\Emails;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\EscortAdmin\Emails\ManageController;

class ReadEmailController extends Controller
{
    /**
     * Handles email display
     *
     * @param int $id
     */
    public function handle($id)
    {
        $this->setTitle(__('View Email'));

        $email = $this->emailRepository->find($id);

        if ($email != null) {
            if ($email && ($email->recipient_user_id == $this->getAuthUser()->getKey())) {
                $this->emailRepository->markEmailAsSeen($email);
            } else {
                $this->notifyError(__("You're not allowed to view this email."));

                // Display the manage page
                return redirect()->route('escort_admin.emails.manage');
            }

            return view('EscortAdmin::emails.view', [
                'email' => $email,
                'email_count' => $this->getUnreadEmailCount()
            ]);
        } else {
            $this->notifyError(__("Email does not exist."));

            // Display the manage page
            return redirect()->route('escort_admin.emails.manage');
        }
    }
}

<?php
/**
 * Handles email deletion
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Http\Controllers\EscortAdmin\Emails;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeleteEmailController extends Controller
{
    /**
     * Deletes the email
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {

        if (! is_null($this->request->input('cb_email'))) {
            $emailId = $this->request->input('cb_email');

            if (is_array($emailId)) {
                $counter = count($emailId);
                $successCounter = 0;

                foreach ($emailId as $id) {
                    $email = $this->emailRepository->find($id);

                    if ($email && ($email->recipient_user_id == $this->getAuthUser()->getKey())) {
                        if ($this->emailRepository->delete($id)) {
                            $successCounter += 1;
                        }
                    } else {
                        $this->notifyError(__("You're not allowed to view this email."));
                        return redirect()->route('escort_admin.emails.manage');
                        break;
                    }
                }

                if ($successCounter == $counter) {
                    $this->notifySuccess(__('Email(s) successfully deleted.'));
                }
            } else {
                $this->notifyError(__('Could not delete email. Please try again later.'));
            }
        } else if ($this->request->input('email_id')) {

            $id = $this->request->input('email_id');
            $email = $this->emailRepository->find($id);

            if ($email && ($email->recipient_user_id == $this->getAuthUser()->getKey())) {
                $response = $this->emailRepository->delete($id);

                if ($response) {
                    $this->notifySuccess(__('Email Successfully deleted'));
                }
            } else {
                $this->notifyError(__("You're not allowed to view this email."));
                return redirect()->route('escort_admin.emails.manage');
            }
        } else {
            $this->notifyWarning(__('No email(s) selected'));
        }

        return redirect()->route('escort_admin.emails.manage');
    }
}

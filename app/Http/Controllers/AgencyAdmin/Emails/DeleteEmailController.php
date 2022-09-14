<?php
/**
 * Handles email deletion
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 * @modified Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Http\Controllers\AgencyAdmin\Emails;

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
        $ids = $this->request->input('cb_email', []) ?: [];

        // append single selected id
        if (empty($ids)) {
            if ($id = $this->request->input('email_id')) {
                $ids = [$id];
            }
        }

        // flag if something faileds
        $failed = false;

        if (! empty($ids) && is_array($ids)) {
            foreach ($ids as $id) {
                $email = $this->emails->find($id);

                // not found
                if (! $email) {
                    $this->notifyError(__('Email does not exists'));
                    $failed = true;
                    break;
                }

                if ($email->recipient->getKey() != $this->getAuthUser()->getKey()) {
                    $this->notifyError(__('Invalid email'));
                    $failed = true;
                    break;
                }

                // process delete
                $this->emails->delete($email->getKey());
            }
        } else {
            $failed = true;
            $this->notifyWarning(__('No email(s) selected'));
        }

        if (! $failed) {
            $this->notifySuccess(__('Email(s) successfully deleted.'));
        }

        return redirect()->route('agency_admin.emails.manage');
    }
}

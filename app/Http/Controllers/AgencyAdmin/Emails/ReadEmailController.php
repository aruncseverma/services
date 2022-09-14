<?php
/**
 * Handles email viewing and decrypting
 *
 * @author Jhay Bagas <bagas.jhay@email.com>
 * @modified Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Http\Controllers\AgencyAdmin\Emails;

use App\Models\UserEmail;
use Illuminate\Contracts\View\View;

class ReadEmailController extends Controller
{
    /**
     * Handles email display
     *
     * @param  App\Models\UserEmail $email
     *
     * @return Illuminate\Contracts\View\View
     */
    public function handle(UserEmail $email) : View
    {
        $this->setTitle(__('View Email'));

        // invalid
        if ($email->recipient->getKey() != $this->getAuthUser()->getKey()) {
            abort(404);
        }

        if ($email) {
            $this->emails->markEmailAsSeen($email);
        }

        return view('AgencyAdmin::emails.view', [
            'email' => $email,
            'email_count' => $this->getUnreadEmailCount()
        ]);
    }
}

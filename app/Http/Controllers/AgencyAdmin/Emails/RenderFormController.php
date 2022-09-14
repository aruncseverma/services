<?php
/**
 * controller class for rendering email form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\AgencyAdmin\Emails;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class RenderFormController extends Controller
{
    /**
     * Renders the form in sending emails
     *
     * @return View
     */
    public function view() : View
    {
        $this->setTitle(__('Compose Email'));

        return view('AgencyAdmin::emails.form', [
            'email_count' => $this->getUnreadEmailCount(),
            'requestedEmails' => $this->getEmailsFromRequest(),
        ]);
    }

    /**
     * get all emails from request
     *
     * @return array
     */
    protected function getEmailsFromRequest() : array
    {
        if (! $ids = $this->request->get('id')) {
            return [];
        }

        $ids = explode(',', (string) $ids);
        $users = $this->users->getAllByEmails($ids);

        return $users->transform(function ($user) {
            return ($user->getKey() != $this->getAuthUser()->getKey()) ? $user->email : null;
        })->toArray();
    }
}

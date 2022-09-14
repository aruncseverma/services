<?php
/**
 * controller class for viewing list of emails
 *
 * @author Mike Alvarez <email@email.com>
 */

namespace App\Http\Controllers\EscortAdmin\Emails;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * renders the emails listing view
     *
     * @param  Illuminate\Http\Request
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request) : View
    {
        $this->setTitle(__('Emails'));

        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'recipient_user_id' => $this->getAuthUser()->getKey(),
            ]
        );

        $emails = $this->emailRepository->search($limit, $search);

        return view('EscortAdmin::emails.manage', [
            'emails' => $emails,
            'email_count' => $this->getUnreadEmailCount()
        ]);
    }
}

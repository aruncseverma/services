<?php
/**
 * controller class for viewing list of emails
 * 
 */

namespace App\Http\Controllers\MemberAdmin\Emails;

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
        $this->setTitle(__('Email'));

        $search = array_merge(
            [
                'limit' => $limit = $this->getPageSize(),
            ],
            $request->query(),
            [
                'recipient_user_id' => $this->getAuthUser()->getKey(),
            ]
        );

        $emails = $this->emails->search($limit, $search);

        return view('MemberAdmin::emails.manage', [
            'emails' => $emails,
            'email_count' => $this->getUnreadEmailCount()
        ]);
    }
}

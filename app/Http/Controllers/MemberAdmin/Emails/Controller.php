<?php
/**
 * Core controller for the Emails Module
 */
namespace App\Http\Controllers\MemberAdmin\Emails;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Repository\UserEmailRepository;
use App\Http\Controllers\MemberAdmin\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * Request Variable
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * Email Repository
     *
     * @var App\Repository\UserEmailRepository
     */
    protected $emails;

    /**
     * User Repository
     *
     * @var App\Repository\UserRepository;
     */
    protected $users;

    /**
     * Undocumented function
     *
     * @param Illuminate\Http\Request               $request
     * @param App\Repository\UserRepository         $users
     * @param App\Repository\UserEmailRepository    $repository
     */
    public function __construct(Request $request, UserRepository $users, UserEmailRepository $emails)
    {
        $this->request = $request;
        $this->users = $users;
        $this->emails = $emails;

        parent::__construct();
    }

    /**
     * Gets the total number of unread emails
     *
     * @return integer
     */
    protected function getUnreadEmailCount() : int
    {
        return $this->emails->getAllUnreadEmails($this->getAuthUser()->getKey());
    }
}

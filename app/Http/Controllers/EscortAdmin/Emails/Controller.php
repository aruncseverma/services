<?php
/**
 * Core controller for the Emails Module
 *
 * @author Jhay Bagas <bagas.jhay@email.com>
 */
namespace App\Http\Controllers\EscortAdmin\Emails;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Repository\UserEmailRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;

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
    protected $emailRepository;

    /**
     * User Repository
     *
     * @var App\Repository\UserRepository;
     */
    protected $userRepository;

    /**
     * Undocumented function
     *
     * @param Illuminate\Http\Request               $request
     * @param App\Repository\UserRepository         $users
     * @param App\Repository\UserEmailRepository    $repository
     */
    public function __construct(Request $request, UserRepository $users, UserEmailRepository $repository)
    {
        $this->request = $request;
        $this->userRepository = $users;
        $this->emailRepository = $repository;

        parent::__construct();
    }

    /**
     * Gets the total number of unread emails
     *
     * @return integer
     */
    protected function getUnreadEmailCount() : int
    {
        return $this->emailRepository->getAllUnreadEmails($this->getAuthUser()->getKey());
    }
}

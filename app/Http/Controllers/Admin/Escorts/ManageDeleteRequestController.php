<?php
/**
 * controller class for managing delete accounts by users
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Repository\EscortRepository;
use App\Http\Controllers\Admin\Controller;
use App\Repository\AccountDeletionRequestRepository;

class ManageDeleteRequestController extends Controller
{
    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * creates instance
     *
     * @param App\Repository\AccountDeletionRequestRepository $repository
     */
    public function __construct(AccountDeletionRequestRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();

        // permission
        $this->middleware('can:escorts.manage');
    }

    /**
     * renders manage page
     *
     * @param  Illuminate\Http\Request         $request
     * @param  App\Repository\EscortRepository $repository
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(Request $request, EscortRepository $repository) : View
    {
        $this->setTitle(__('Account Closed By Members'));

        $search = array_merge(
            [
                'name'  => null,
                'limit' => $limit = $this->getPageSize(),
                'type'  => Escort::USER_TYPE,
                'is_active' => '*'
            ],
            $request->query()
        );

        $requests = $this->repository->search($limit, $search);

        return view('Admin::escorts.manage_deleted', [
            'requests' => $requests,
            'search' => $search,
            'count' => [
                'total' => $repository->getTotal(),
                'pending' => $repository->getTotalPending(),
                'approved' => $repository->getTotalApproved(),
                'blocked' => $repository->getTotalBlocked()
            ]
        ]);
    }
}

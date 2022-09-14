<?php
/**
 * controller class for managing Escorts
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use App\Models\Escort;
use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * all escorts view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function all() : View
    {
        $this->setTitle(__('Manage Escorts'));

        return $this->getView($this->request->query());
    }

    /**
     * all pending approval escorts view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function pending() : View
    {
        $this->setTitle(__('Manage Pending Escorts'));

        return $this->getView(
            array_merge([
                'is_approved' => false
            ], $this->request->query())
        );
    }

    /**
     * get manage view instance
     *
     * @param  array $search
     * @return Illuminate\Contracts\View\View
     */
    protected function getView(array $search = []) : View
    {
        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'name'      => null,
                'is_active' => '*',
                'type'      => self::DEFAULT_TYPE,
                'limit'     => $limit,
            ],
            $search
        );

        // get users from repository
        $users  = $this->repository->search($limit, $search);

        // addons
        $addons = [
            'users' => $users,
            'search' => $search,
            'count' => [
                'total' => $this->repository->getTotal(),
                'pending' => $this->repository->getTotalPending(),
                'approved' => $this->repository->getTotalApproved(),
                'blocked' => $this->repository->getTotalBlocked()
            ]
        ];

        if (isset($search['is_approved']) && $search['is_approved'] == false) {
            $notifications = $this->getAuthUser()->unreadNotifications->where('type', 'like', 'App\Notifications\Admin\User\NewEscort');
            
            $pending = [];
            foreach($notifications as $notif) {
                $pending[$notif->data['email']] = $notif->id;
            }

            if (count($pending) > 0) {
                $addons['pending'] = $pending;
            }
        }

        // create view instance
        $view = view('Admin::escorts.manage')
            ->with($addons);

        return $view;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:escorts.manage');
    }
}

<?php

namespace App\Http\Controllers\Admin\Members;

use Illuminate\Contracts\View\View;

class ManageController extends Controller
{
    /**
     * create controller view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Manage Members'));

        $limit  = $this->getPageSize();
        $search = array_merge(
            [
                'name'      => null,
                'is_active' => '*',
                'type'      => self::DEFAULT_TYPE,
                'limit'     => $limit,
                'email'     => null,

            ],
            $this->request->query()
        );

        // get users from repository
        $users  = $this->repository->search($limit, $search);

        // create view instance
        $view = view('Admin::members.manage')
            ->with([
                'users' => $users,
                'search' => $search,
            ]);

        return $view;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:members.manage');
    }
}

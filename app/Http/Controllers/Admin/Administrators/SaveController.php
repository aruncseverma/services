<?php
/**
 * controller class for saving administrator form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Administrators;

use App\Models\Administrator;
use Illuminate\Validation\Rule;
use App\Repository\RoleRepository;
use Illuminate\Http\RedirectResponse;

class SaveController extends Controller
{
    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = null;
        if ($id = $this->request->get('id')) {
            $user =  $this->repository->find($id);
            if (! $user) {
                $this->notifyError(__('User not found.'));
                return redirect()->back();
            }

            if ($user->getKey() == config('app.super_admin_user_id') && !$this->isSuperAdmin()) {
                $this->notifyError(__('Permission Denied.'));
                return redirect()->back();
            }
        }

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save user
        $user = $this->saveUser($user);

        // notify next request
        $this->notifySuccess(__('Data successfully saved.'));

        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Administrator|null $user
     *
     * @return void
     */
    protected function validateRequest(Administrator $user = null) : void
    {
        // get role repository
        $roleRepository = app(RoleRepository::class);

        $rules = [
            'email'            => ['required', 'email'],
            'password'         => ['nullable', 'min:6'],
            'confirm_password' => ['same:password'],
            'name'             => 'nullable',
            'is_active'        => 'boolean',
            'username'         => ['nullable'],
            'role_id'          => [
                Rule::exists($roleRepository->getTable(), $roleRepository->getModel()->getKeyName()),
            ],
        ];

        // create unique rule
        $unique = Rule::unique($this->repository->getTable());

        // append additional rules
        if (! is_null($user)) {
            // appends ignore current model to be updated
            $unique->ignoreModel($user);

            $rules['email'][] = $unique;
            $rules['username'][] = $unique;
        } else {
            $rules['email'][] = $unique;
            $rules['username'][] = $unique;
            $rules['password'][] = 'required';
        }

        // validate request
        $this->validate(
            $this->request,
            $rules
        );
    }

    /**
     * save user data
     *
     * @param  App\Models\Administrator|null $user
     *
     * @return App\Models\Administrator
     */
    protected function saveUser(Administrator $user = null) : Administrator
    {
        $attributes = [
            'email'     => $this->request->input('email'),
            'username'  => $this->request->input('username'),
            'name'      => $this->request->input('name'),
            'is_active' => $this->request->input('is_active'),
            'type'      => ($user) ? $user->type : self::DEFAULT_TYPE,
            'role_id'   => $this->request->input('role_id'),
        ];

        if ($this->request->filled('password')) {
            $attributes['password'] = $this->request->input('password');
        }

        // save to repository
        $user = $this->repository->save($attributes, $user);

        return $user;
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\Administrator $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Administrator $user) : RedirectResponse
    {
        return redirect()->route(
            'admin.administrator.update',
            [
                'id'   => $user->getKey(),
            ]
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        if ($this->request->has('id')) {
            $this->middleware('can:administrators.update');
        } else {
            $this->middleware('can:administrators.create');
        }
    }
}

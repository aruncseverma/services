<?php

namespace App\Http\Controllers\Admin\Members;

use App\Models\Member;
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
                $this->notifyError(__('Member not found.'));
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
     * @param  App\Models\Member|null $user
     *
     * @return void
     */
    protected function validateRequest(Member $user = null) : void
    {
        $rules = [
            'email'            => ['required', 'email'],
            'password'         => ['nullable', 'min:6'],
            'confirm_password' => ['same:password'],
            'name'             => 'nullable',
            'is_active'        => 'boolean',
            'username'         => ['nullable'],
            'is_newsletter_subscriber' => 'boolean',
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
     * @param  App\Models\Member|null $user
     *
     * @return App\Models\Member
     */
    protected function saveUser(Member $user = null) : Member
    {
        $attributes = [
            'email'     => $this->request->input('email'),
            'username'  => $this->request->input('username'),
            'name'      => $this->request->input('name'),
            'is_active' => $this->request->input('is_active'),
            'type'      => ($user) ? $user->type : self::DEFAULT_TYPE,
            'is_newsletter_subscriber' => $this->request->input('is_newsletter_subscriber')
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
     * @param  App\Models\Member $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Member $user) : RedirectResponse
    {
        return redirect()->route(
            'admin.member.update',
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
            $this->middleware('can:members.update');
        } else {
            $this->middleware('can:members.create');
        }
    }
}

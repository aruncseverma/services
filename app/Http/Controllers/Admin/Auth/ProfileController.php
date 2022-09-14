<?php
/**
 * authenticated user profile controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repository\AdministratorRepository;

class ProfileController extends Controller
{
    /**
     * create instance
     *
     * @param Illuminate\Http\Request                $request
     * @param App\Repository\AdministratorRepository $repository
     */
    public function __construct(Request $request, AdministratorRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * view authenticated user form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index() : View
    {
        // set title
        $this->setTitle(__('My Profile'));

        // get authenticated user
        $user = $this->getAuthUser();

        return view('Admin::auth.profile', ['user' => $user]);
    }

    /**
     * handle incoming request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle() : RedirectResponse
    {
        $user = $this->getAuthUser();
        $prev = clone $user;

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save user
        $this->saveUser($user);

        // notify next request
        $this->notifySuccess(__('Data successfully saved.'));

        $this->logInfo(
            sprintf('User #%d updated his/her profile', $user->getKey()),
            [
                'ip' => $this->request->ip(),
                'updated'  => $user->toArray(),
                'previous' => $prev->toArray()
            ]
        );

        return redirect()->route('admin.auth.profile_form');
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
        $rules = [
            'email'            => ['required', 'email'],
            'password'         => ['nullable', 'min:6'],
            'confirm_password' => ['same:password'],
            'name'             => 'nullable',
            'username'         => ['nullable'],
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
        ];

        if ($this->request->filled('password')) {
            $attributes['password'] = $this->request->input('password');
        }

        // save to repository
        $user = $this->repository->save($attributes, $user);

        return $user;
    }
}

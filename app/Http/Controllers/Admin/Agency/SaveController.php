<?php
/**
 * controller class for saving Agency form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Agency;

use App\Models\Agency;
use App\Notifications\Admin\Agency\NewAgency;
use Illuminate\Validation\Rule;
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
        }

        // validate request if passed then proceeds to saving user info
        $this->validateRequest($user);

        // save user
        $user = $this->saveUser($user);

        // notify next request
        $this->notifySuccess(__('Data successfully saved.'));

        // add admin notification
        $this->getAuthUser()->notify(new NewAgency($user->name, $user->email));

        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Agency|null $user
     *
     * @return void
     */
    protected function validateRequest(Agency $user = null) : void
    {
        $rules = [
            'email'            => ['required', 'email'],
            'password'         => ['nullable', 'min:6'],
            'confirm_password' => ['same:password'],
            'agency_name'      => 'required',
            'is_active'        => 'boolean',
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
     * @param  App\Models\Agency|null $user
     *
     * @return App\Models\Agency
     */
    protected function saveUser(Agency $user = null) : Agency
    {
        $attributes = [
            'email'     => $this->request->input('email'),
            'username'  => $this->request->input('username'),
            'name'      => $this->request->input('agency_name'),
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
     * @param  App\Models\Agency $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Agency $user) : RedirectResponse
    {
        return redirect()->route(
            'admin.agency.update',
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
            $this->middleware('can:agency.update');
        } else {
            $this->middleware('can:agency.create');
        }
    }
}

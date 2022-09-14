<?php
/**
 * controller class for saving Escort form
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\Admin\Escorts;

use App\Models\Escort;
use App\Notifications\Admin\User\NewEscort;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Repository\UserDataRepository;

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

        // notify admin
        $this->getAuthUser()->notify(new NewEscort($user->name, $user->email));

        if ((empty($id) && $user->is_active === true) // for add
            || !empty($id)
        ) { //for edit
            $this->removeEscortFilterCache([
                'no_filter', // no filter
                'origin', // [B] origin field
                'search', // [B] name field
                'totay', 
            ]);
        }
        return $this->redirectTo($user);
    }

    /**
     * validate incoming request
     *
     * @param  App\Models\Escort|null $user
     *
     * @return void
     */
    protected function validateRequest(Escort $user = null) : void
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
     * @param  App\Models\Escort|null $user
     *
     * @return App\Models\Escort
     */
    protected function saveUser(Escort $user = null) : Escort
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

        // save user data
        $this->saveUserData($user);

        return $user;
    }

    /**
     * save user data
     *
     * @param  App\Models\Escort $user
     *
     * @return void
     */
    protected function saveUserData(Escort $user) : void
    {
        $userDataFields = ['origin_id'];
        $repository = app(UserDataRepository::class);

        $fields = [];
        foreach ($userDataFields as $field) {
            $fields[$field] = $this->request->input($field, '');
        }
        $repository->saveUserData($user, $fields);
    }

    /**
     * redirect to next route
     *
     * @param  App\Models\Escort $user
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(Escort $user) : RedirectResponse
    {
        return redirect()->route(
            'admin.escort.update',
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
            $this->middleware('can:escorts.update');
        } else {
            $this->middleware('can:escorts.create');
        }
    }
}

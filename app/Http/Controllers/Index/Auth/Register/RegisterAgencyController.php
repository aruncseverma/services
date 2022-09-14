<?php

namespace App\Http\Controllers\Index\Auth\Register;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\Agency;

class RegisterAgencyController extends RegisterMemberController
{
    /**
     * default type
     *
     * @const
     */
    const DEFAULT_TYPE = Agency::USER_TYPE;

    /**
     * renders register view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function renderForm(): View
    {
        // set title
        $this->setTitle(__('Agency Register'));

        // disable main wrapper
        $this->disableMainWrapper();

        return view('Index::auth.register.agency_form');
    }

    /**
     * validate incoming request
     *
     * @return void
     */
    protected function validateRequest(): void
    {
        $unique = Rule::unique($this->repository->getTable());
        $rules = [
            'email'                 => ['required', 'email', $unique],
            'username'              => ['required', $unique],
            'password'              => ['required', 'min:6'],
            'confirm_password'      => ['same:password'],
            'name'                  => 'required',
            //'gender'                => ['required'],
            'continent'    => ['required', 'continents'],
            'country'      => ['required', 'countries'],
            'state'        => ['required', 'states'],
            'city'         => ['required', 'cities'],
            'terms' => 'required',
            'g-recaptcha-response' => 'required|google_recaptcha'
        ];

        // validate request
        $this->validate(
            $this->request,
            $rules,
            [],
            ['g-recaptcha-response' => 'Recaptcha']
        );
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getAuthGuardName(): string
    {
        return 'agency_admin';
    }
}

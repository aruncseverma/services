<?php
/**
 * custom rule for validating current authenticated password if matched with the current requested one
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Validation;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Validation\Validator as LaravelValidatorContract;

class CurrentPasswordValidator extends Validator
{
    /**
     * laravel config instance
     *
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * laravel auth instance
     *
     * @var Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * hasher instance
     *
     * @var Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * create instance
     *
     * @param Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config, Factory $auth, Hasher $hasher)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->hasher = $hasher;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, $value, array $parameters, LaravelValidatorContract $validator) : bool
    {
        $guard = (isset($parameters[0])) ? $parameters[0] : $this->config->get('auth.defaults.guard');
        $user = $this->getAuthGuard($guard)->user();

        return $this->hasher->check($value, $user->getAuthPassword());
    }

    /**
     * get laravel auth guard for given auth guard name
     *
     * @param  string $guard
     *
     * @return Illuminate\Contracts\Auth\Guard
     */
    protected function getAuthGuard(string $guard) : Guard
    {
        return $this->auth->guard($guard);
    }
}

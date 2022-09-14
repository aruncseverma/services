<?php
/**
 * service provider class for validation concerns
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Providers;

use Illuminate\Validation\Factory;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * list of defined custom rules for validation
     *
     * format:
     *
     * [
     *  '<rule_name>' => [
     *      'replacer' => '<class_name>@<method>
     *      'validate' => '<class_name>@<method>
     *  ]
     * ]
     *
     * @var array
     */
    protected $customRules = [
        'current_password' => [
            'replacer' => 'App\Support\Validation\CurrentPasswordValidator@replacer',
            'validate' => 'App\Support\Validation\CurrentPasswordValidator@validate',
        ],
        'continents' => [
            'replacer' => 'App\Support\Validation\ContinentValidator@replacer',
            'validate' => 'App\Support\Validation\ContinentValidator@validate',
        ],
        'countries' => [
            'replacer' => 'App\Support\Validation\CountryValidator@replacer',
            'validate' => 'App\Support\Validation\CountryValidator@validate',
        ],
        'states' => [
            'replacer' => 'App\Support\Validation\StatesValidator@replacer',
            'validate' => 'App\Support\Validation\StatesValidator@validate',
        ],
        'cities' => [
            'replacer' => 'App\Support\Validation\CityValidator@replacer',
            'validate' => 'App\Support\Validation\CityValidator@validate',
        ],
        'google_recaptcha' => [
            'replacer' => 'App\Support\Validation\GoogleRecaptchaValidator@replacer',
            'validate' => 'App\Support\Validation\GoogleRecaptchaValidator@validate',
        ],
    ];

    /**
     * boot services
     *
     * @return void
     */
    public function boot() : void
    {
        $this->bootCustomValidationRules();
    }

    /**
     * boot custom validation rules
     *
     * @return void
     */
    protected function bootCustomValidationRules() : void
    {
        $factory = $this->getValidatorFactory();

        // register rules
        foreach ($this->customRules as $rule => $option) {
            $factory->extend($rule, $option['validate']);
            $factory->replacer($rule, $option['replacer']);
        }
    }

    /**
     * get validator instance
     *
     * @return Illuminate\Contracts\Validation\Factory
     */
    protected function getValidatorFactory() : Factory
    {
        return $this->app->make('validator');
    }
}

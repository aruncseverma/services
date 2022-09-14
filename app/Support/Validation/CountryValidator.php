<?php
/**
 * custom validation rule for countries
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Validation;

use App\Repository\CountryRepository;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class CountryValidator extends Validator
{
    /**
     * countries repository
     *
     * @var App\Repository\CountryRepository
     */
    protected $countries;

    /**
     * create instance
     *
     * @param App\Repository\CountryRepository $countries
     */
    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string                                    $attribute
     * @param  mixed                                     $value
     * @param  array                                     $parameters
     * @param  Illuminate\Contracts\Validation\Validator $validator
     *
     * @return boolean
     */
    public function validate(string $attribute, $value, array $parameters, ValidatorContract $validator) : bool
    {
        return $this->countries->isActiveCountry($value);
    }
}

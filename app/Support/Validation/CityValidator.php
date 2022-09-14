<?php
/**
 * custom validation rule for city
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Validation;

use App\Repository\CityRepository;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class CityValidator extends Validator
{
    /**
     * cities repository
     *
     * @var App\Repository\CityRepository
     */
    protected $cities;

    /**
     * create instance
     *
     * @param App\Repository\CityRepository $cities
     */
    public function __construct(CityRepository $cities)
    {
        $this->cities = $cities;
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
        return $this->cities->isActiveCity($value);
    }
}

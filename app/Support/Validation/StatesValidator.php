<?php
/**
 * custom validation rule for states
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Validation;

use App\Repository\StateRepository;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class StatesValidator extends Validator
{
    /**
     * states repository
     *
     * @var App\Repository\StateRepository
     */
    protected $states;

    /**
     * create instance
     *
     * @param App\Repository\StateRepository $states
     */
    public function __construct(StateRepository $states)
    {
        $this->states = $states;
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
        return $this->states->isActiveState($value);
    }
}

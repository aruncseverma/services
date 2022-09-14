<?php
/**
 * country select template composer class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\CountryRepository;

class CountryViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\CountryRepositor $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * get select options
     *
     * @param  mixed $value
     *
     * @return Illuminate\Support\Collection
     */
    protected function getOptions($value = null) : Collection
    {
        $results = $this->repository->findAll(['is_active' => true]);
        $countries = [];

        foreach ($results as $result) {
            $expected = $result->getKey();
            $isSelected = (is_array($value)) ? in_array($expected, $value, true) : $expected == $value;
            $countries[] = new Option($result->getKey(), $result->name, $isSelected);
        }

        return new Collection($countries);
    }
}

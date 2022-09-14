<?php
/**
 * cities form input view composer class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\CityRepository;

class CityViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\CityRepository $repository
     */
    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * get select options
     *
     * @return Illuminate\Support\Collection
     */
    protected function getOptions($value = null) : Collection
    {
        $results = $this->repository->findAll([]);
        $cities = [];

        foreach ($results as $result) {
            $expected = $result->getKey();
            $isSelected = (is_array($value)) ? in_array($expected, $value, true) : $expected === $value;
            $cities[] = new Option($result->getKey(), $result->name, $isSelected);
        }

        return new Collection($cities);
    }
}

<?php
/**
 * composer class for continent selection
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\ContinentRepository;

class ContinentViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\ContinentRepository $repository
     */
    public function __construct(ContinentRepository $repository)
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
        $results = $this->repository->findAll([]);
        $continents = [];

        foreach ($results as $result) {
            $expected = $result->getKey();
            $isSelected = (is_array($value)) ? in_array($expected, $value, true) : $expected == $value;
            $continents[] = new Option($result->getKey(), $result->name, $isSelected);
        }

        return new Collection($continents);
    }
}

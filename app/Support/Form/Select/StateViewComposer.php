<?php
/**
 * composer class for states selection
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\StateRepository;

class StateViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\StateRepository $repository
     */
    public function __construct(StateRepository $repository)
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
        $states = [];

        foreach ($results as $result) {
            $expected = $result->getKey();
            $isSelected = (is_array($value)) ? in_array($expected, $value, true) : $expected == $value;
            $states[] = new Option($result->getKey(), $result->name, $isSelected);
        }

        return new Collection($states);
    }
}

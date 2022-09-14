<?php
/**
 * composer class for currency selection
 *
 * 
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\CurrencyRepository;

class CurrencyViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\CurrencyRepository $repository
     */
    public function __construct(CurrencyRepository $repository)
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
      $options = [];

      foreach ($results as $result) {
          $expected = $result->getKey();
          $isSelected = (is_array($value)) ? in_array($expected, $value, true) : $expected === $value;
          $options[] = new Option($result->getKey(), $result->name, $isSelected);
      }

      return new Collection($options);
    }
}

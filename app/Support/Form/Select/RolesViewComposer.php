<?php
/**
 * roles select template composer class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use App\Repository\RoleRepository;

class RolesViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * @param App\Repository\RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
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
        $roles = [];

        foreach ($results as $result) {
            $isSelected = $result->getKey() == $value;
            $roles[] = new Option($result->getKey(), $result->group, $isSelected);
        }

        return new Collection($roles);
    }
}

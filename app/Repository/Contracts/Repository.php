<?php
/**
 * repository contract class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Repository
{
    /**
     * get current repository table name
     *
     * @return string
     */
    public function getTable() : string;

    /**
     * set current repository table name
     *
     * @param string $table
     *
     * @return void
     */
    public function setTable(string $table);

    /**
     * get repository query builder
     *
     * @return Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder();

    /**
     * set repository query builder
     *
     * @param  Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder $builder
     *
     * @return void
     */
    public function setBuilder($builder) : void;

    /**
     * update/create model instance
     *
     * @param  array $attributes
     * @param  mixed $model
     *
     * @return mixed
     */
    public function save(array $attributes);

    /**
     * get all collection of the models
     *
     * @return Illuminate\Support\Collection
     */
    public function all() : Collection;

    /**
     * find a model from the record using primary key value
     *
     * @param  mixed $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * find result by using a condition
     *
     * @param  mixed $where
     *
     * @return mixed
     */
    public function findBy($where);

    /**
     * find all model collection
     *
     * @param array $params
     *
     * @return void
     */
    public function findAll(array $params = []) : Collection;

    /**
     * delete a row
     *
     * @param  mixed $id
     *
     * @return boolean
     */
    public function delete($id) : bool;

    /**
     * get model collection as paginated
     *
     * @param  integer $pageSize
     * @param  array $params
     * @param  array $columns
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $pageSize, array $params = [], array $columns = ['*']) : LengthAwarePaginator;
}

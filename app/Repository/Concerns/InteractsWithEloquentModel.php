<?php
/**
 * usable methods for repositories which interacts with eloquent model
 * classes
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait InteractsWithEloquentModel
{
    /**
     * eloquent model instance
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * repository table name
     *
     * @var string
     */
    protected $table;

    /**
     * builder instance
     *
     * @var Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * set repository table name
     *
     * @param string $table
     *
     * @return void
     */
    public function setTable(string $table) : void
    {
        $this->table = $table;
    }

    /**
     * get repository table name
     *
     * @return string
     */
    public function getTable() : string
    {
        return $this->table;
    }

    /**
     * set repository query builder
     *
     * @param  Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder $builder
     *
     * @return void
     */
    public function setBuilder($builder) : void
    {
        $this->builder = $builder;
    }

    /**
     * set repository model instance
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function setModel(Model $model) : void
    {
        $this->model = $model;
    }

    /**
     * get repository model instance
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getModel() : Model
    {
        return $this->model;
    }

    /**
     * update/create model instance
     *
     * @param  array $attributes
     * @param  mixed $model
     *
     * @return mixed
     */
    public function save(array $attributes, $model = null)
    {
        if (is_null($model)) {
            $model = $this->getModel()->newInstance();
        }

        // set attributes
        foreach ($attributes as $attribute => $value) {
            $model->setAttribute($attribute, $value);
        }

        // save model
        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     *
     * @return Illuminate\Support\Collection
     */
    public function all() : Collection
    {
        return $this->getModel()->all();
    }

    /**
     * find a model from the record using primary key value
     *
     * @param  mixed $id
     *
     * @return Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->getModel()->find($id);
    }

    /**
     * delete a model to records and return a bool
     *
     * @param  mixed $id
     * @return boolean
     */
    public function delete($id) : bool
    {
        $model = $this->find($id);
        return (bool) ($model) ? $model->delete() : false;
    }

    /**
     * {@inheritDoc}
     *
     * @param  mixed $params
     *
     * @return Illuminate\Database\Eloquent\Model|null
     */
    public function findBy($where)
    {
        return $this->getBuilder()->where($where)->first();
    }

    /**
     * {@inheritDoc}
     *
     * @param array $params
     *
     * @return Illuminate\Support\Collection
     */
    public function findAll(array $params = []) : Collection
    {
        return $this->getBuilder()->where($params)->get();
    }

    /**
     * wraps model findMany method
     *
     * @param  array $ids
     *
     * @return Illuminate\Support\Collection
     */
    public function findMany(array $ids) : Collection
    {
        return $this->getBuilder()->findMany($ids);
    }

    /**
     * get model collection as paginated
     *
     * @param  integer $pageSize
     * @param  array $params
     * @param  array $columns
     *
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $pageSize, array $params = [], array $columns = ['*']) : LengthAwarePaginator
    {
        return $this->getBuilder()->where($params)->paginate($pageSize, $columns);
    }

    /**
     * get repository query builder
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder()
    {
        return $this->getModel()->newModelQuery();
    }

    /**
     * restores soft deleted model
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     *
     * @return boolean
     */
    public function restore(Model $model) : bool
    {
        return (bool) $model->restore();
    }

    /**
     * set Builder instance from model
     *
     * @param  Illuminate\Database\Eloquent\Model|null $model
     *
     * @return void
     */
    protected function setBuilderFromModel(Model $model = null)
    {
        if (! is_null($model)) {
            $this->setModel($model);
        }

        $this->setBuilder($this->getModel()->newModelQuery());
    }

    /**
     * get table name from model
     *
     * @return string
     */
    protected function getTableFromModel() : string
    {
        return $this->getModel()->getTable();
    }

    /**
     * bool eloquent repository class
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    protected function bootEloquentRepository(Model $model) : void
    {
        $this->setBuilderFromModel($model);
        $this->setTable($this->getTableFromModel());
    }

    /**
     * get new model instance of the repository model
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function newModelInstance() : Model
    {
        return $this->getModel()->newInstance();
    }
}

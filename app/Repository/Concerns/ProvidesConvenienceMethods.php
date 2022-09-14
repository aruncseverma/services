<?php
/**
 * trait class for providing convinient methods
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository\Concerns;

use InvalidArgumentException;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait ProvidesConvenienceMethods
{
    /**
     * checks if current model is instance of the given classname
     *
     * @throws InvalidArgumentException
     *
     * @param  mixed  $model
     * @param  string $classname
     *
     * @return boolean
     */
    protected function isModelInstanceOf($model, $classname) : bool
    {
        if ($model && ! $model instanceof $classname) {
            throw new \InvalidArgumentException(
                sprintf(
                    'argument 1 must be an instance of %s, instance of %s given',
                    $classname,
                    get_class($model)
                )
            );
        }

        return true;
    }

    /**
     * create sort clause in the query builder
     *
     * @throws InvalidArgumentException
     *
     * @param  mixed  $builder
     * @param  string $field
     * @param  string $order
     * @param  array $allowedFields
     * @return void
     */
    protected function createBuilderSort($builder, string $field, string $order, array $allowedFields = [])
    {
        // allowed order value
        $allowedOrder = [
            'asc',
            'desc',
        ];

        // if not found in the allowed orders
        if (! in_array(strtolower($order), $allowedOrder)) {
            $order = 'asc';
        }

        // checks if argument is instance of laravel query builder
        if (! $builder instanceof QueryBuilder && ! $builder instanceof EloquentBuilder) {
            throw new InvalidArgumentException(
                sprintf(
                    'Argument 1 must instance of %s or %s, %s given',
                    QueryBuilder::class,
                    EloquentBuilder::class,
                    get_class($builder)
                )
            );
        }

        $builder->orderBy($field, $order);
    }
}

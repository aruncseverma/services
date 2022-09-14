<?php

namespace App\Events\Repository\Users;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CreatingSearchBuilder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * builder instance
     *
     * @var Illuminate\Database\Query\Builder
     *      Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * requested params
     *
     * @var array
     */
    protected $params = [];

    /**
     * Create a new event instance.
     *
     * @param  Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder $builder
     * @param  array                                                                  $params
     *
     * @return void
     */
    public function __construct($builder, array $params = [])
    {
        $this->builder = $builder;
        $this->params  = $params;
    }
}

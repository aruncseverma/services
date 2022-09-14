<?php

namespace App\Repository;

use App\Models\Subscriber;

class NewsletterRepository extends Repository
{

    public function __construct(Subscriber $model)
    {
        $this->bootEloquentRepository($model);
    }
}
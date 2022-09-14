<?php
/**
 * abstract repository class
 *
 * @author  <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

abstract class Repository implements Contracts\Repository
{
    use Concerns\ProvidesConvenienceMethods,
        Concerns\InteractsWithEloquentModel;
}

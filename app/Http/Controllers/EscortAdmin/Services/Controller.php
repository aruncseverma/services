<?php
/**
 * base controller class for namespace Services in escort admin namespace
 * also this namespace is for the escort rates, schedules and services
 *
 * @abstract
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Support\Concerns\EscortFilterCache;

abstract class Controller extends BaseController
{
    use EscortFilterCache;
}

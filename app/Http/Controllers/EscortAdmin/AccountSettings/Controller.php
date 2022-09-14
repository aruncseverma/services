<?php
/**
 * base controller for account settings namespace
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 * @abstract
 */

namespace App\Http\Controllers\EscortAdmin\AccountSettings;

use App\Http\Controllers\EscortAdmin\Controller as BaseController;
use App\Support\Concerns\EscortFilterCache;

abstract class Controller extends BaseController
{
    // ..
    use EscortFilterCache;
}

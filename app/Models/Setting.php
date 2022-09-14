<?php
/**
 * setting eloquent model class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * set fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'value'
    ];
}

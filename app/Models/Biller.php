<?php
/**
 * biller eloquent model class
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Biller extends Model
{
    /**
     * model does not have any timestamps as attributes
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * cast attributes
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool'
    ];

    /**
     * checks if biller is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAttribute('is_active');
    }
}

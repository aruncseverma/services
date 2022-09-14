<?php
/**
 * eloquent model class for currencies
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * cast attributes to defined datatype
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
        'rate' => 'double',
    ];

    /**
     * checks if currency is active
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getAttribute('is_active');
    }
}

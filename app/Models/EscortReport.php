<?php
/**
 * escort reports eloquent model class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortReport extends Model
{
    /**
     * relation to escort model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'escort_user_id');
    }

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }
}

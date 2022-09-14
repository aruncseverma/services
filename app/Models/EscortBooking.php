<?php
/**
 * escort bookings eloquent model class
 *
 * @author Jomel Gapuz <mjagapuz@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortBooking extends Model
{
    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }
}

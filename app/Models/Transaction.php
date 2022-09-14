<?php
/**
 * transaction eloquent model class
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Transaction extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];
   
    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to_user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class UserView extends Model
{
    /**
     * model eloquent table name
     *
     * @var string
     */
    protected $table = 'user_views';

    /**
     * this eloquent model does not have any timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * relation to user model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

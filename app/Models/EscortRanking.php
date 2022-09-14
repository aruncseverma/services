<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortRanking extends Model
{
    /**
     * model eloquent table name
     *
     * @var string
     */
    protected $table = 'escort_ranking';

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
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }
}

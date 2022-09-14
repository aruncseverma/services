<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class AgencyRanking extends Model
{
    /**
     * model eloquent table name
     *
     * @var string
     */
    protected $table = 'agency_ranking';

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
    public function agency() : Relations\BelongsTo
    {
        return $this->belongsTo(Agency::class, 'user_id');
    }
}

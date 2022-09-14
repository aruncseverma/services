<?php
/**
 * eloquent class model for table rate_duration_descriptions
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class RateDurationDescription extends Model
{
    /**
     * this model does not have any timestamps defined
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * relation to language model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language() : Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }

    /**
     * relation to rate duration model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rateDuration() : Relations\BelongsTo
    {
        return $this->belongsTo(RateDuration::class, 'rate_duration_id');
    }
}

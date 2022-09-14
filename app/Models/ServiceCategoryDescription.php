<?php
/**
 * eloquent model for service category description
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class ServiceCategoryDescription extends Model
{
    /**
     * this model does not have any timestamps defined
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * relationships that will be updated when this model is updated
     *
     * @var array
     */
    protected $touches = [
        'category',
    ];

    /**
     * relation to service category model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() : Relations\BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    /**
     * relation to language model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language() : Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }
}

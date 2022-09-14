<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class PostCategoryDescription extends Model
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
     * relation to language model
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language(): Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }

    /**
     * relation to post category model
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(): Relations\BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }
}

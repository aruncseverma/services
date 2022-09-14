<?php
/**
 * eloquent model class user emails
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Carbon\Carbon;

class UserEmail extends Model
{
    /**
     * cast attributes to specified data type
     *
     * @var array
     */
    protected $casts = [
        'is_starred' => 'bool',
    ];

    /**
     * attributes with date as data type
     * @author Jhay Bagas <bagas.jhay@gmail.com>
     *
     * @var array
     */
    protected $date = [
        'seen_at'
    ];

    /**
     * relation to user model (sender)
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * relation to user model (recipient)
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient() : Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    /**
     * mutatator for `content` attribute
     *
     * @param string $content
     *
     * @return void
     */
    public function setContentAttribute(string $content) : void
    {
        $this->attributes['content'] = encrypt($content);
    }

    /**
     * accesor for `content` attribute
     *
     * @return string|null
     */
    public function getContentAttribute() : ?string
    {
        return @decrypt($this->attributes['content']);
    }

    /**
     * checks if current email is starred
     *
     * @return boolean
     */
    public function isStarred() : bool
    {
        return $this->getAttribute('is_starred');
    }

    /**
     * checks if current email is seen
     *
     * @return boolean
     */
    public function isSeen() : bool
    {
        return $this->attributes['seen_at'] !== null;
    }

    /**
     * get the created date of review
     *
     * @return string
     */
    public function getDateAttribute(): string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('m/d/Y');
        }
        return '';
    }

    /**
     * get the created time of review
     *
     * @return string
     */
    public function getTimeAttribute(): string
    {
        if (isset($this->attributes['created_at']) && !empty($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('h:i:s A');
        }
        return '';
    }
}

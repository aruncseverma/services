<?php
/**
 * escort schedules eloquent class model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class EscortSchedule extends Model
{
    /**
     * day schedules
     *
     * @const
     */
    const SCHEDULE_MONDAY = 'M';
    const SCHEDULE_TUESDAY = 'T';
    const SCHEDULE_WEDNESDAY = 'W';
    const SCHEDULE_THURSDAY = 'TH';
    const SCHEDULE_FRIDAY = 'F';
    const SCHEDULE_SATURDAY = 'ST';
    const SCHEDULE_SUNDAY = 'SN';

    /**
     * array of allowed schedules value
     *
     * @const
     */
    const ALLOWED_SCHEDULES = [
        self::SCHEDULE_MONDAY,
        self::SCHEDULE_TUESDAY,
        self::SCHEDULE_WEDNESDAY,
        self::SCHEDULE_THURSDAY,
        self::SCHEDULE_FRIDAY,
        self::SCHEDULE_SATURDAY,
        self::SCHEDULE_SUNDAY
    ];

    /**
     * time format for time columns
     *
     * @const
     */
    const TIME_FORMAT = 'H:i';

    /**
     * this model does not have any timestamps fields
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * attributes default value
     *
     * @var array
     */
    protected $attributes = [
        'from' => '00:00',
        'till' => '00:00',
    ];

    /**
     * relation to escort model class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function escort() : Relations\BelongsTo
    {
        return $this->belongsTo(Escort::class, 'user_id');
    }

    /**
     * accessor method for from attribute
     *
     * @return string
     */
    public function getFromAttribute() : string
    {
        return $this->parseTime($this->attributes['from']);
    }

    /**
     * accessor method for till attribute
     *
     * @return string
     */
    public function getTillAttribute() : string
    {
        return $this->parseTime($this->attributes['till']);
    }

    /**
     * parse value to time format
     *
     * @param  mixed $value
     *
     * @return string
     */
    protected function parseTime($value) : string
    {
        return Carbon::parse($value)->format(static::TIME_FORMAT);
    }
}

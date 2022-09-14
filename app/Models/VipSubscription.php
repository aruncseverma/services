<?php

namespace App\Models;

use App\Models\Biller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VipSubscription extends Model
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'payment_id',
        'date_paid',
        'duration',
        'expiration_date',
        'order_id',
        'vip_status'
    ];

    /**
     * returns user data
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * returns biller info
     *
     * @return BelongsTo
     */
    public function biller() : BelongsTo
    {
        return $this->belongsTo(Biller::class, 'payment_id');
    }

    /**
     * returns membership plan purchased
     *
     * @return BelongsTo
     */
    public function membership() : BelongsTo
    {
        return $this->belongsTo(Membership::class, 'plan_id');
    }

    /**
     * returns payment information
     *
     * @return HasOne
     */
    public function payment() : HasOne
    {
        return $this->hasOne(PlanPayments::class, 'trans_id');
    }
}

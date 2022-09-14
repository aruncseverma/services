<?php
/**
 * 
 */
namespace App\Models;

use App\Models\User;
use App\Models\VipSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanPayments extends Model
{
    protected $table = 'payment_transaction';

    protected $fillable = [
        'trans_id',
        'admin_id',
        'reference_id',
        'attachment'
    ];

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function plan() : BelongsTo
    {
        return $this->belongsTo(VipSubscription::class, 'trans_id');
    }
}

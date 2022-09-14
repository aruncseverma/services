<?php
/**
 * revoke membership model
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevokeMembership extends Model
{
    protected $table = 'vip_revoke';

    protected $fillable = [
        'transaction_id',
        'admin_id',
        'reason'
    ];

    /**
     * get admin information
     *
     * @return BelongsTo
     */
    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * get transaction information
     *
     * @return BelongsTo
     */
    public function transaction() : BelongsTo
    {
        return $this->belongsTo(VipSubscription::class, 'transaction_id');
    }
}

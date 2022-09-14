<?php
/**
 * wallet model repository class
 *
 */

namespace App\Repository;

use App\Models\Wallet;

class WalletRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Wallet $model
     */
    public function __construct(Wallet $model)
    {
        $this->bootEloquentRepository($model);
    }

    public function getWallet($user)
    {
        $wallet = Wallet::where('user_id', $user->id)->first();
        // New Wallet if it does not exist.
        if ($wallet == null) {
            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->amount = 0;
            $wallet->save();
        }
        return $wallet;
    }
}

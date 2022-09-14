<?php
/**
 * transaction model repository class
 *
 */

namespace App\Repository;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionRepository extends Repository
{
  /**
   * create instance
   *
   * @param App\Models\Transaction $model
   */
  public function __construct(Transaction $transaction)
  {
      $this->bootEloquentRepository($transaction);
  }

  public function createTransaction($user, $package, $wallet, $type, $note = null)
  {
      $transaction = new Transaction;
      $transaction->type = $type;
      $transaction->from_amount = $package->price;
      $transaction->to_user_id = $user->id;
      $transaction->to_wallet_id = $wallet->id;
      $transaction->to_amount = $package->credits;
      $transaction->status = 'Pending';
      if ($note) {
          $transaction->note = $note;
      }
      $transaction->save();

      return $transaction;
  }

  public function getTransaction($id)
  {
    return Transaction::find($id);
  }

  public function confirmTransaction($transaction)
  {
    DB::transaction(function () use ($transaction) {
      Transaction::find($transaction->id)->update(['status' => 'Confirmed']);
      Wallet::where('user_id', $transaction->to_user_id)->increment('amount', (int) $transaction->to_amount);
    }, 5);
  }

  public function refundTransaction($transaction)
  {
    DB::transaction(function () use ($transaction) {
      Transaction::find($transaction->id)->update(['status' => 'Refunded']);
      Wallet::where('user_id', $transaction->to_user_id)->decrement('amount', (int) $transaction->to_amount);
    }, 5);
  }

  public function cancelTransaction($transaction)
  {
    Transaction::find($transaction->id)->update(['status' => 'Canceled']);
  }

  /**
   * search for paginated result set
   *
   * @param  integer $limit
   * @param  array   $params
   *
   * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function search(int $limit, array $params = []) : LengthAwarePaginator
  {
      $builder = $this->createSearchBuilder($params);

      // create paginated result
      return $builder->paginate($limit)->appends($params);
  }

  /**
   * create search builder instance
   *
   * @param  array $params
   *
   * @return Illuminate\Database\Eloquent\Builder
   */
  protected function createSearchBuilder(array $params = []) : Builder
  {
    $builder = $this->getBuilder()->with('to_user')->with('from_user')->orderBy('id', 'desc');

    if (isset($params['status']) && ($status = $params['status']) !== '*') {
      $builder->where('status', $status);
    }

    // with 'user' search in user.id, user.name, user.username in both 'from' and 'to' fields.
    $builder->whereHas('to_user', function ($query) use ($params) {
      if (isset($params['user']) && ($user = $params['user']) !== '') {
        $query->where('id', $user)
          ->orWhere('name', $user)
          ->orWhere('username', $user);
      }
    })
    ->orwhereHas('from_user', function ($query) use ($params) {
      if (isset($params['user']) && ($user = $params['user']) !== '') {
        $query->where('id', $user)
          ->orWhere('name', $user)
          ->orWhere('username', $user);
      }
    });
    return $builder;
  }
}

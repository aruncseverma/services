<?php
/**
 * 
 */

namespace App\Http\Controllers\Admin\Finance;
use App\Repository\TransactionRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * renders the form for the transactions in the admin backend site
 */
class TransactionsController extends Controller
{
    /**
     * transaction repository instance
     *
     * @var App\Repository\TransactionRepository
     */
    protected $transactions;

    /**
     * view site transactions form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(TransactionRepository $transactions) : View
    {
        $this->setTitle(__('Transactions'));

        $limit = $this->getPageSize();
        $search = array_merge(
            [
                'limit' => $limit,
                'status' => '*',
                'user' => '',
            ],
            $this->request->query()
        );
        $transactions = $transactions->search($limit, $search);

        // create view
        return view('Admin::finance.transactions', [
            'search'    => $search,
            'transactions' => $transactions,
        ]);
    }

    public function view(TransactionRepository $transactions) : View
    {
      // get transaction info
      $transaction = $transactions->find($this->request->get('id'));

      // create view instance
      return view('Admin::finance.viewtransaction', [
          'transaction' => $transaction,
      ]);
    }

    public function refund(TransactionRepository $transactions) : RedirectResponse
    {
      // get transaction info
      $transaction = $transactions->find($this->request->get('id'));

      // redirect if no user was found
      if (!$transaction) {
          $this->notifyError(__('Transaction not found'));
          return redirect()->back();
      }

      // update repository
      $transaction = $transactions->refundTransaction($transaction);

      // notify
      $this->notifySuccess(__('Transaction status is updated successfully.'));
    
      return redirect()->back();
    }

    public function confirm(TransactionRepository $transactions) : RedirectResponse
    {
      // get transaction info
      $transaction = $transactions->find($this->request->get('id'));

      // redirect if no user was found
      if (!$transaction) {
          $this->notifyError(__('Transaction not found'));
          return redirect()->back();
      }

      // update repository
      $transaction = $transactions->confirmTransaction($transaction);

      // notify
      $this->notifySuccess(__('Transaction status is updated successfully.'));
    
      return redirect()->back();
    }

    public function cancel(TransactionRepository $transactions) : RedirectResponse
    {
      // get transaction info
      $transaction = $transactions->find($this->request->get('id'));

      // redirect if no user was found
      if (!$transaction) {
          $this->notifyError(__('Transaction not found'));
          return redirect()->back();
      }

      // update repository
      $transaction = $transactions->cancelTransaction($transaction);

      // notify
      $this->notifySuccess(__('Transaction status is updated successfully.'));
    
      return redirect()->back();
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware() : void
    {
        $this->middleware('can:general_settings.manage');
    }
}

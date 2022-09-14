<?php
/**
 * Buy Credits namespace base controller
 *
 */

namespace App\Http\Controllers\EscortAdmin\BuyCredits;

use Illuminate\Http\Request;
use App\Repository\BillerRepository;
use App\Repository\PackageRepository;
use App\Repository\WalletRepository;
use App\Repository\TransactionRepository;
use App\Repository\CurrencyRepository;
use App\Http\Controllers\EscortAdmin\Controller as BaseController;

abstract class Controller extends BaseController
{

    /**
     * laravel request object
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * billers repository instance
     *
     * @var App\Repository\BillerRepository
     */
    protected $billers;

    /**
     * packages repository instance
     *
     * @var App\Repository\PackageRepository
     */
    protected $packages;

    /**
     * create instance of this controller
     *
     * @param Illuminate\Http\Request         $request
     * @param App\Repository\BillerRepository $repository
     */
    public function __construct(Request $request, BillerRepository $billers, PackageRepository $packages, WalletRepository $wallet, TransactionRepository $transaction, CurrencyRepository $currency)
    {
        $this->request = $request;
        $this->billers = $billers;
        $this->packages = $packages;
        $this->wallet = $wallet;
        $this->transaction = $transaction;
        $this->currency = $currency;

        parent::__construct();
    }
}

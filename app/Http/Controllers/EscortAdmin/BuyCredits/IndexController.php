<?php
/**
 * Buy Credits index controller
 *
 */

namespace App\Http\Controllers\EscortAdmin\BuyCredits;

use Illuminate\Contracts\View\View;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * handle dashboard request
     *
     * @return Illuminate\Contracts\View\View
     */

    public function view() : View
    {
        $this->setTitle(__('strings.BuyCredits'));

        /* active biller is 2 (credit card) as default */
        $active = 2;
        $currency = 2;

        $billers = $this->billers->getAllActive();
        $packages = $this->packages->getPackages($active);
        $currencies = $this->currency->getActiveCurrencies();

        return view('Common::buycredits.index', [
            'baselayout' => 'EscortAdmin::layout',
            'billers' => $billers,
            'active' => $active,
            'packages' => $packages,
            'currencies' => $currencies,
            'activecurrency' => '2',
        ]);
    }

    public function getPackages() : View
    {
        $packages = $this->packages->getPackages($this->request->id, $this->request->currency);
        $currencies = $this->currency->getActiveCurrencies();
        $activecurrency = $this->request->currency;

        return view('Common::buycredits.packages', [
            'packages' => $packages,
            'currencies' => $currencies,
            'activecurrency' => $activecurrency,
        ]);
    }

    public function getPayPage() : View
    {
        $package = $this->packages->find($this->request->id);
        $biller = $this->billers->find($package->biller_id);
        $template = '';

        $user = $this->getAuthUser();
        $wallet = $this->wallet->getWallet($user);
        $transaction = $this->transaction->createTransaction($user, $package, $wallet, 'Payment', json_encode([
            'paymentType' => $biller->name,
            'currencySymbol' => ($package->currency->symbol_right != '') ? $package->currency->symbol_right : $package->currency->symbol_left,
        ]));
        
        $billNote = '';
        switch ($biller->id) {
            case 1: // Bank Transfer
                $template = 'Common::buycredits.paypageBank';
                $billNote = str_replace('__TRANSACTIONID__', $transaction->id, $biller->billnote);
                break;
            case 2: // Credit Card
                $template = 'Common::buycredits.paypageCC';
                break;
            case 3: // Paypal
                $template = 'Common::buycredits.paypagePayPal';
                break;
            case 4: // Western Union
                $template = 'Common::buycredits.paypageWU';
                $billNote = $biller->billnote;
                break;
            case 5: // Dummy biller (test only)
                $template = 'Common::buycredits.paypageDummy';
                break;
            default: // no biller page?
                $template = 'Common::buycredits.paypageEmpty';
        }

        return view($template, [
            'package' => $package,
            'biller' => $biller,
            'transaction' => $transaction,
            'billnote' => $billNote,
        ]);
    }

    public function getConfirmPage() : View
    {
        if ($this->request->transactionid == null) {
            return view('Common::buycredits.error');
        }

        $transaction = $this->transaction->getTransaction($this->request->transactionid);

        if (json_decode($transaction->note)->paymentType === 'Dummy') {
            /* in case of Dummy, update the transaction & wallet */
            $this->transaction->confirmTransaction($transaction);
        }
       
        $confirmed = $this->request->confirmation;

        if ($confirmed == 'cancel') {
            $this->transaction->cancelTransaction($transaction);
        }

        switch ($confirmed) {
            case 'success':
                $template = 'Common::buycredits.thankyou';
                break;
            case 'xxxxx':
                $template = 'Common::buycredits.thankyou';
                break;
            default: // All non-success
                $template = 'Common::buycredits.error';
        }

         return view($template, [
            'transaction' => $transaction,
         ]);
    }
}

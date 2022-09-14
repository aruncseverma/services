<?php
/**
 * controller class for updating escort rates
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Models\Escort;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use App\Repository\EscortRateRepository;
use App\Support\Concerns\NeedsCurrencies;
use App\Support\Concerns\NeedsRateDurations;

class UpdateRatesController extends Controller
{
    use NeedsCurrencies,
        NeedsRateDurations;

    /**
     * repository instance
     *
     * @var App\Repository\EscortRateRepository
     */
    protected $repository;

    /**
     * create instance
     *
     * @param App\Repository\EscortRateRepository $repository
     */
    public function __construct(EscortRateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request) : RedirectResponse
    {
        $this->validateRequest($request);

        $escort = $this->getAuthUser();
        $currency = $this->getCurrencyRepository()->find($request->input('currency_id'));

        if (! $currency) {
            $this->notifyError(__('Rate currency was not selected or invalid'));
            return $this->redirectTo();
        } elseif (! $currency->isActive()) {
            $this->notifyError(__('Rate currency is not active'));
            return $this->redirectTo();
        }

        // save and notify
        $this->saveRates($request->input('rates', []), $escort, $currency);

        $this->notifySuccess(__('Rates successfully saved'));

        // redirect
        return $this->redirectTo();
    }

    /**
     * validate request data
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateRequest(Request $request) : void
    {
        $this->validate(
            $request,
            [
                'rates' => 'array',
                'rates.*.incall' => 'nullable|numeric',
                'rates.*.outcall' => 'nullable|numeric',
            ],
            [
                'numeric' => __('Invalid amount provided'),
            ]
        );
    }

    /**
     * save escort rates
     *
     * @param  array               $rates
     * @param  App\Models\Escort   $escort
     * @param  App\Models\Currency $currency
     *
     * @return boolean
     */
    protected function saveRates(array $rates, Escort $escort, Currency $currency) : bool
    {
        foreach ($this->getRateDurations() as $duration) {
            $id = $duration->getKey();

            // if current duration is set from the rates data
            if (isset($rates[$id])) {
                $rate = $escort->getRate($id, $currency);

                // save
                $this->repository->store(
                    [
                        'incall' => $rates[$id]['incall'] ?: 0.00,
                        'outcall' => $rates[$id]['outcall'] ?: 0.00,
                    ],
                    $escort,
                    $currency,
                    $duration,
                    $rate
                );
            }
        }

        return true;
    }

    /**
     * redirect to next request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectTo() : RedirectResponse
    {
        return back()->withInput(['notify' => 'rates']);
    }
}

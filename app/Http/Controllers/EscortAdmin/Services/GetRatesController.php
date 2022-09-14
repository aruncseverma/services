<?php

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Models\Escort;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repository\EscortRateRepository;
use App\Support\Concerns\NeedsCurrencies;
use App\Support\Concerns\NeedsRateDurations;

class GetRatesController extends Controller
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
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(Request $request) : JsonResponse
    {
        $escort = $this->getAuthUser();
        $currency = $this->getCurrencyRepository()->find($request->input('currency_id'));

        $status = 1;
        $message = __('Success');
        $data = [];
        if (! $currency) {
            $status = 0;
            $message = __('Rate currency was not selected or invalid');

        } elseif (! $currency->isActive()) {
            $status = 0;
            $message = __('Rate currency is not active');
        } else {
            $data = $escort->rates->where('currency_id', $currency->getKey());
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}

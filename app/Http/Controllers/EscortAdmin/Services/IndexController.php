<?php
/**
 * renders escorts rates, services, and schedules form controller class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Http\Controllers\EscortAdmin\Services;

use App\Models\EscortService;
use App\Models\EscortSchedule;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\NeedsCurrencies;
use App\Repository\RateDurationRepository;
use App\Support\Concerns\NeedsRateDurations;
use App\Support\Concerns\NeedsServiceCategories;

class IndexController extends Controller
{
    use NeedsCurrencies,
        NeedsRateDurations,
        NeedsServiceCategories;
    /**
     * render view form
     *
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View
    {
        $this->setTitle(__('Rates, Schedules & Services'));

        // get authenticated escort
        $escort = $this->getAuthUser();
        $currencies = $this->getCurrencies();
        $currentCurrency = ($rate = $escort->rates->first())
            ? $rate->currency
            : $currencies->first();

        return view('EscortAdmin::services.form', [
            'escort' => $escort,
            'days' => $this->getDays(),
            'currencies' => $currencies,
            'currentCurrency' => $currentCurrency,
            'durations' => $this->getRateDurations(),
            'categories' => $this->getServiceCategories(),
            'serviceTypesOptions' => $this->getServiceTypes(),
        ]);
    }

    /**
     * get schedule days
     *
     * @return array
     */
    protected function getDays() : array
    {
        return [
            EscortSchedule::SCHEDULE_MONDAY => __('Monday'),
            EscortSchedule::SCHEDULE_TUESDAY => __('Tuesday'),
            EscortSchedule::SCHEDULE_WEDNESDAY => __('Wednesday'),
            EscortSchedule::SCHEDULE_THURSDAY => __('Thursday'),
            EscortSchedule::SCHEDULE_FRIDAY => __('Friday'),
            EscortSchedule::SCHEDULE_SATURDAY => __('Saturday'),
            EscortSchedule::SCHEDULE_SUNDAY => __('Sunday'),
        ];
    }

    /**
     * get service types options
     *
     * @return array
     */
    protected function getServiceTypes() : array
    {
        return [
            EscortService::TYPE_STANDARD => __('Standard'),
            EscortService::TYPE_EXTRA => __('Extra'),
            EscortService::TYPE_NOT => __('Not')
        ];
    }
}

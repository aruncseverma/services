<?php
/**
 * usable methods for classes that needs application currencies
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Illuminate\Support\Collection;
use App\Repository\CurrencyRepository;

trait NeedsCurrencies
{
    /**
     * currency cache key
     *
     * @var string
     */
    protected $currenciesCacheKey = 'currencies';

    /**
     * get currencies list
     *
     * @return Illuminate\Support\Collection
     */
    public function getCurrencies() : Collection
    {
        if (app()->environment(['local', 'dev'])) {
            return $this->getCurrenciesFromRepository();
        }

        return $this->getCurrenciesFromCache();
    }

    /**
     * get currency repository instance
     *
     * @return App\Repository\CurrencyRepository
     */
    protected function getCurrencyRepository() : CurrencyRepository
    {
        return app(CurrencyRepository::class);
    }

    /**
     * get currencies from the repository
     *
     * @return Illuminate\Support\Collection
     */
    protected function getCurrenciesFromRepository() : Collection
    {
        return $this->getCurrencyRepository()->getActiveCurrencies();
    }

    /**
     * get currencies from cached object
     *
     * @return Illuminate\Support\Collection
     */
    protected function getCurrenciesFromCache() : Collection
    {
        $cache = app('cache');

        // if does not have store it forever to cache
        if (! $cache->has($this->currenciesCacheKey)) {
            $cache->rememberForever($this->currenciesCacheKey, function () {
                return $this->getCurrenciesFromRepository();
            });
        }

        return $cache->get($this->currenciesCacheKey);
    }

    /**
     * clears stored cache
     *
     * @return void
     */
    protected function forgetCurrenciesCache() : void
    {
        app('cache')->forget($this->currenciesCacheKey);
    }

    /**
     * get current default currency
     *
     * @return mixed
     */
    public function getDefaultCurrency()
    {
        return $this->getCurrencyRepository()->getDefaultCurrency();
    }
}

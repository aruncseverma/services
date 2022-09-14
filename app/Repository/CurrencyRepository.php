<?php
/**
 * repository class for currency eloquent model
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Repository;

use App\Models\Currency;
use Illuminate\Support\Collection;

class CurrencyRepository extends Repository
{
    /**
     * create instance
     *
     * @param App\Models\Currency $model
     */
    public function __construct(Currency $model)
    {
        $this->bootEloquentRepository($model);
    }

    /**
     * get all active currencies from the repository
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveCurrencies() : Collection
    {
        return $this->getBuilder()
            ->where(['is_active' => true])
            ->orderBy('is_default', 'DESC')
            ->get();
    }

    /**
     * get current default currency
     *
     * @return \App\Models\Currency|null
     */
    public function getDefaultCurrency() : ?Currency
    {
        return $this->getBuilder()
            ->where(['is_active' => true])
            ->where(['is_default' => true])
            ->first();
    }
}

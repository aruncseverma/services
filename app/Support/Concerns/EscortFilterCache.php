<?php

namespace App\Support\Concerns;

use App\Support\Notifications\Contracts\Handler;
use Illuminate\Support\Facades\Cache;

trait EscortFilterCache
{
    protected $cacheId = 'filter_escort';
    protected $cacheKeys = [];

    public function getCacheId()
    {
        return $this->cacheId;
    }
    public function getCacheKeys($isSaved = true)
    {
        $cacheKeys = $this->cacheKeys;
        if (Cache::has($this->cacheId)) {
            $cacheKeys = Cache::get($this->getCacheId());
        }
        if ($isSaved) {
            $this->cacheKeys = $cacheKeys;
        }

        return $cacheKeys;
    }
    private function removeCacheKeys()
    {
        return $this->cacheKeys = [];
    }

    public function getEscortsCache($params = [], $cb)
    {
        // get all cache keys
        $cacheId = $this->getCacheId();

        // generate cache key using params
        ksort($params);
        $cacheKey = $cacheId . '_' . http_build_query($params);

        $escorts = [];
        if (Cache::has($cacheKey)) {
            $escorts = Cache::get($cacheKey);
        } else {
            if (is_callable($cb)) {
                $escorts = $cb();
            }
            Cache::forever($cacheKey, $escorts);
            $cacheKeys = $this->getCacheKeys();
            $cacheKeys[$cacheKey] = true;
            Cache::forever($cacheId, $cacheKeys);
        }

        return $escorts;
    }

    
    /**
     * Remove filter escort cache
     * 
     * @param string|array $mixed delete by specific keys
     * @return void
     */
    public function removeEscortFilterCache($mixed = null)
    {
        $noFilterKey = 'filter_escort_';
        $cacheKeys = $this->getCacheKeys(false);
        if (!empty($cacheKeys)) {
            if (is_null($mixed) || empty($mixed)) {
                foreach ($cacheKeys as $key => $val) {
                    //dump('remove : '.$key, Cache::get($key));
                    Cache::forget($key);
                }
                Cache::forget($this->getCacheId());
            } else if (is_array($mixed)) {
                foreach($mixed as $removeKey) {
                    if ($removeKey == 'no_filter') {
                        if (isset($cacheKeys[$noFilterKey])) {
                            Cache::forget($noFilterKey);
                            unset($cacheKeys[$noFilterKey]);
                        }
                    } else {
                        foreach ($cacheKeys as $key => $val) {
                            if (
                                strpos($key, '_' . $removeKey . '=') !== false
                                || strpos($key, '&' . $removeKey . '=') !== false
                            ) {
                                Cache::forget($key);
                                unset($cacheKeys[$key]);
                            }
                        }
                    }
                }
                Cache::forever($this->getCacheId(), $cacheKeys);
            } else {
                if ($mixed == 'no_filter') {
                    if (isset($cacheKeys[$noFilterKey])) {
                        Cache::forget($noFilterKey);
                        unset($cacheKeys[$noFilterKey]);
                    }
                } else {
                    foreach ($cacheKeys as $key => $val) {
                        if (
                            strpos($key, '_' . $mixed . '=') !== false
                            || strpos($key, '&' . $mixed . '=') !== false
                        ) {
                            Cache::forget($key);
                            unset($cacheKeys[$key]);
                        }
                    }
                }
               
                Cache::forever($this->getCacheId(), $cacheKeys);
            }
        } else {
            Cache::forget($this->getCacheId());
        }
    }
}
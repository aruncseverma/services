<?php
/**
 * usable method(s) for interacting with requested page size
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

trait InteractsWithPageSize
{
    /**
     * get page size from request
     * or from configuration repository
     *
     * @param  string $for
     *
     * @return int
     */
    public function getPageSize()
    {
        $request  = app('request');
        $pageSize = $request->get('limit');

        return ((int) $pageSize) ?: (int) $this->getDefaultPageSize();
    }

    /**
     * get default page size in request is null
     *
     * @return int
     */
    abstract protected function getDefaultPageSize() : int;
}

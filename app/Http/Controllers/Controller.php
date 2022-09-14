<?php

namespace App\Http\Controllers;

use App\Support\Concerns\HasNotifications;
use App\Support\Concerns\InteractsWithAuth;
use App\Support\Concerns\InteractsWithLogger;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Support\Concerns\InteractsWithLayout;
use App\Support\Concerns\InteractsWithPageSize;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Support\Concerns\InteractsWithUserActivity;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        HasNotifications,
        InteractsWithLayout,
        InteractsWithAuth,
        InteractsWithPageSize,
        InteractsWithLogger,
        InteractsWithUserActivity;

    /**
     * {@inheritDoc}
     *
     * @return integer
     */
    protected function getDefaultPageSize() : int
    {
        return config('admin.page_size');
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getAuthGuardName(): string
    {
        return 'member_admin';
    }
}

<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Admin\Posts\DeletePhotoController as BaseController;

class DeletePhotoController extends BaseController
{
    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        $this->middleware('can:pages.update');
    }
}

<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Admin\Posts\UploadPhotoController as BaseController;
use App\Models\Post;

class UploadPhotoController extends BaseController
{
    const POST_TYPE = Post::PAGE_TYPE;

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    protected function attachMiddleware(): void
    {
        if ($this->request->has('post_id')) {
            $this->middleware('can:pages.update');
        } else {
            $this->middleware('can:pages.create');
        }
    }
}

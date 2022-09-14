<?php

namespace App\Support\Post;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Support\Concerns\InteractsWithAuth;

class PostViewComposer
{
    use InteractsWithAuth;

    /**
     * create instance
     *
     * @param Request $request
     */
    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    /**
     * compose template
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $activeAuths = config('app.activeAuths');
        if (is_null($activeAuths)) {
            $activeAuths = $this->getActiveAuths();
            config(['app.activeAuths'=> $activeAuths]);
        }

        $view->with('activeAuths', $activeAuths);
    }
}

<?php
/**
 * view composer for topbar view template
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Topbar;

use Illuminate\Contracts\View\View;
use App\Support\Concerns\InteractsWithAuth;

class TopbarViewComposer
{
    use InteractsWithAuth;

    /**
     * compose view parameters to view
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view) : void
    {
        $view->with('user', $this->getAuthUser());
    }
}

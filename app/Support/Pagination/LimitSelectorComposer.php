<?php
/**
 * view composer for vendor.pagination.* for limit selector
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Pagination;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Support\Concerns\InteractsWithPageSize;

class LimitSelectorComposer
{
    use InteractsWithPageSize;

    /**
     * selection limit
     *
     * @var array
     */
    protected $selections = [
        10,
        25,
        50,
        100,
        150,
        200,
    ];

    /**
     * create instance
     *
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * composer template
     *
     * @param  \Illuminate\Contracts\View\View   $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $paginator = $view->offsetGet('paginator');
        $limit = $this->request->get('limit', config('admin.page_size'));
        $from  = ($limit *( $paginator->currentPage() - 1)) + 1;
        $to = $limit * $paginator->currentPage();

        $view->with('limitOptions', $this->createLimitOptions());
        $view->with('selectedLimit', $limit);
        $view->with('from', $from);
        $view->with('to', $to);
    }

    /**
     * creates limit options
     *
     * @todo  default should be in the config not static
     *
     * @return void
     */
    protected function createLimitOptions()
    {
        $request = app('request');
        $route   = $request->route();
        $name    = $route->getName();
        $params  = $request->query();
        $options = [];

        foreach ($this->selections as $selection) {
            // do not include already selected
            if ($this->getPageSize() == $selection) {
                continue;
            }

            // append to params
            $params['limit'] = $selection;

            if (! is_null($name)) {
                $link = route($name, $params);
            } else {
                $link = url($route->uri(), $params);
            }

            $options[] = [
                'value'      => $selection,
                'text'       => $selection,
                'attributes' => 'data-link="' . $link . '"',
                'link'       => $link,
            ];
        }

        return $options;
    }

    /**
     * {@inheritDoc}
     *
     * @return integer
     */
    protected function getDefaultPageSize() : int
    {
        return 5;
    }
}

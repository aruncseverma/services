<?php
/**
 * select template composer class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class SelectViewComposer
{
    /**
     * compose template
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        // disable all options being preloaded usable for
        // select which depends on the other select options value
        if ($view->offsetExists('disable_preloaded')) {
            $options = new Collection([]);
        } else {
            $options = $this->getOptions($view->offsetGet('value'));
        }

        // set is multiple var
        $view->with('isMultiple', ($view->offsetExists('is_multiple')) ? $view->offsetGet('is_multiple') : null);

        if ($view->offsetExists('all')) {
            $options->prepend(new Option('*', __('All'), true));
        }

        if ($view->offsetExists('placeholder')) {
            $options->prepend(new Option('', __('Please select'), true));
        }

        // detects if given value from the view is a array then implode with comma seperated value
        if (is_array($values = $view->offsetGet('value'))) {
            $view->with('value', implode(',', $values));
        }

        $view->with('options', $options);
    }

    /**
     * get select options
     *
     * @param  mixed $value
     *
     * @return Illuminate\Support\Collection
     */
    protected function getOptions($value = null) : Collection
    {
        return new Collection([]);
    }
}

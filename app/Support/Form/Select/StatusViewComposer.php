<?php
/**
 * composer class for status selection
 *
 * 
 */

namespace App\Support\Form\Select;

use Illuminate\Support\Collection;

class StatusViewComposer extends SelectViewComposer
{
    /**
     * create instance
     *
     * 
     */
    public function __construct()
    {
        
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
        $results = ['Pending','Confirmed','Canceled'];
        $options = [];

        foreach ($results as $result) {
            $isSelected = ($result == $value);
            $options[] = new Option($result, $result, $isSelected);
        }

        return new Collection($options);
    }
}

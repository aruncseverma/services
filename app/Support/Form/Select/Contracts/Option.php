<?php
/**
 * select option class contract
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select\Contracts;

interface Option
{
    /**
     * get option value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * get option text
     *
     * @return string
     */
    public function getText() : string;

    /**
     * checks if current menu is selected
     *
     * @return boolean
     */
    public function isSelected() : bool;
}

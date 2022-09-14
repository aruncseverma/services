<?php
/**
 * select option class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Form\Select;

class Option implements Contracts\Option
{
    /**
     * option value
     *
     * @var mixed
     */
    protected $value;

    /**
     * option text
     *
     * @var string
     */
    protected $text = '';

    /**
     * is option selected
     *
     * @var boolean
     */
    protected $isSelected = false;

    /**
     * create instance
     *
     * @param mixed   $value
     * @param string  $text
     * @param boolean $isSelected
     */
    public function __construct($value, string $text, bool $isSelected = false)
    {
        $this->value = $value;
        $this->text = $text;
        $this->isSelected = $isSelected;
    }

    /**
     * get option value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * get option text
     *
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * checks if current menu is selected
     *
     * @return boolean
     */
    public function isSelected() : bool
    {
        return $this->isSelected;
    }
}

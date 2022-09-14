<?php
/**
 * class for stacking assets in blade template which allows to stack same assets
 * into single stack without repeating the same asset declaration into the template
 * for example when assets will be under a loop if asset is already declared then theres no need to
 * show it again in the html output
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Assets;

use InvalidArgumentException;

class Stack
{
    /**
     * list of assets declared
     *
     * @var array
     */
    protected $stack = [];

    /**
     * defined section
     *
     * @var string
     */
    protected $section = '';

    /**
     * start a stack
     *
     * @param  string $section
     *
     * @return void
     */
    public function startPush(string $section = '') : void
    {
        // start output buffering
        if (ob_start()) {
            $this->stack[] = $section;
        }

        $this->section = $section;
    }

    /**
     * stop the stack and push the content to stack
     *
     * @return void
     */
    public function endPush() : void
    {
        if (empty($this->section)) {
            throw new InvalidArgumentException('section must be start first.');
        }

        // push content to stack
        $this->pushStack($this->section, ob_get_clean());
    }

    /**
     * get all stacks
     *
     * @return array
     */
    public function all() : array
    {
        return $this->getStack('*');
    }

    /**
     * get stack based on key
     *
     * @param  string $key
     *
     * @return array
     */
    public function getStack(string $key = '*') : array
    {
        if ($key === '*') {
            return $this->stack;
        }

        return (array_key_exists($key, $this->stack)) ? (array) $this->stack[$key] : [];
    }

    /**
     * yield assets stack
     *
     * @param  string $section
     *
     * @return string
     */
    public function yieldStack(string $section = '') : string
    {
        $output = '';

        // loop stack and display output
        foreach ($this->getStack($section) as $stack => $content) {
            $output .= $content;
        }

        return $output;
    }

    /**
     * push a content to stack
     *
     * @param  string $key
     * @param  string $content
     *
     * @return void
     */
    protected function pushStack(string $key, string $content = '') : void
    {
        if (empty($key)) {
            $this->stack[] = $key;
        }

        // create a hash for checking if content is already push the stack
        $hash = md5($content);

        if (! isset($this->stack[$key])) {
            $this->stack[$key][$hash] = $content;
        } elseif (! isset($this->stack[$key][$hash])) {
            $this->stack[$key][$hash] = $content;
        }
    }
}

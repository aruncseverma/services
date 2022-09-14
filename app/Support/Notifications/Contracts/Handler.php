<?php
/**
 * notification handler contract class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Notifications\Contracts;

interface Handler
{
    /**
     * notification types
     *
     * @const
     */
    const NOTIFY_SUCCESS = 'success';
    const NOTIFY_ERROR   = 'error';
    const NOTIFY_WARNING = 'warning';
    const NOTIFY_INFO    = 'info';

    /**
     * create a new notification
     *
     * @param  string $type
     * @param  string $message
     * @param  array $context
     *
     * @return void
     */
    public function notify(string $type, string $message, array $context = []);

    /**
     * create success notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function success(string $message, array $context = []);

    /**
     * create warning notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function warning(string $message, array $context = []);

    /**
     * create info notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function info(string $message, array $context = []);

    /**
     * create error notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function error(string $message, array $context = []);

    /**
     * retrieves notifications from storage
     *
     * @return array
     */
    public function all() : array;
}

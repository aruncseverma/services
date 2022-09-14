<?php
/**
 * helper methods for creating notifications using laravel
 * flash session feature
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use App\Support\Notifications\Contracts\Handler;

trait HasNotifications
{
    /**
     * create a new notification
     *
     * @param  string $type
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function notify($type, $message, array $context = [])
    {
        return $this->getNotificationHandler()->notify($type, $message, $context);
    }

    /**
     * create success notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function notifySuccess($message, array $context = [])
    {
        return $this->notify('success', $message, $context);
    }

    /**
     * create warning notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function notifyWarning($message, array $context = [])
    {
        return $this->notify('warning', $message, $context);
    }

    /**
     * create info notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function notifyInfo($message, array $context = [])
    {
        return $this->notify('info', $message, $context);
    }

    /**
     * create ERROR notification
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function notifyError($message, array $context = [])
    {
        return $this->notify('error', $message, $context);
    }

    /**
     * get nofications handler
     *
     * @return Handler
     */
    protected function getNotificationHandler() : Handler
    {
        return app('notify');
    }
}

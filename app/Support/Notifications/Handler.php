<?php
/**
 * notification handler class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Notifications;

use Illuminate\Session\SessionManager;

class Handler implements Contracts\Handler
{
    /**
     * notification types
     *
     * @var array
     */
    protected $types = [
        self::NOTIFY_SUCCESS,
        self::NOTIFY_ERROR,
        self::NOTIFY_WARNING,
        self::NOTIFY_INFO
    ];

    /**
     * key from the session
     *
     * @const
     */
    const SESSION_KEY = 'notifications';

    /**
     * create instance
     *
     * @param Illuminate\Session\SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $type
     * @param  string $message
     * @param  array $context
     *
     * @return void
     */
    public function notify(string $type, string $message, array $context = [])
    {
        // create payload key
        $key = md5($type . $message);

        // create payload
        $payload = new Payload($type, $message, $context);

        // push flash session
        $this->store($key, $payload);
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $message
     * @param  array  $context
     * @return void
     */
    public function success(string $message, array $context = [])
    {
        return $this->notify(self::NOTIFY_SUCCESS, $message, $context);
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $message
     * @param  array  $context
     * @return void
     */
    public function info(string $message, array $context = [])
    {
        return $this->notify(self::NOTIFY_INFO, $message, $context);
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $message
     * @param  array  $context
     * @return void
     */
    public function warning(string $message, array $context = [])
    {
        return $this->notify(self::NOTIFY_WARNING, $message, $context);
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $message
     * @param  array  $context
     * @return void
     */
    public function error(string $message, array $context = [])
    {
        return $this->notify(self::NOTIFY_ERROR, $message, $context);
    }

    /**
     * get all notifications
     *
     * @return array
     */
    public function all() : array
    {
        return $this->session->pull(self::SESSION_KEY, []);
    }

    /**
     * store notification payload
     *
     * @param  string $key
     * @param  App\Suppo  $payload
     *
     * @return void
     */
    protected function store(string $key, Payload $payload) : void
    {
        // combine previous notifications
        $previous = $this->session->pull(self::SESSION_KEY, []);

        // push notification payload
        $previous[$key] = $payload;

        // push to session flash stack
        $this->session->flash(self::SESSION_KEY, $previous);
    }
}

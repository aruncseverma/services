<?php
/**
 * notification payload class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Notifications;

class Payload
{
    /**
     * payload type
     *
     * @var string
     */
    public $type;

    /**
     * payload message
     *
     * @var string
     */
    public $message;

    /**
     * payload context
     *
     * @var array
     */
    public $context = [];

    /**
     * create instance
     *
     * @param string $type
     * @param string $message
     * @param array  $context
     */
    public function __construct(string $type, string $message, array $context = [])
    {
        $this->type   = $type;
        $this->message = $message;
        $this->context = $context;
    }
}

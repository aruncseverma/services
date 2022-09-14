<?php
/**
 * usable trait method for interacting with application
 * logger instance
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

trait InteractsWithLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        return $this->getLogger()->log($level, $message, $context);
    }

    /**
     * log with level of error
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logError($message, array $context = [])
    {
        return $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * log with level of emergency
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logEmergency($message, array $context = [])
    {
        return $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * log with level of alert
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logAlert($message, array $context = [])
    {
        return $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * log with level of critical
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logCritical($message, array $context = [])
    {
        return $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * log with level of warning
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logWarning($message, array $context = [])
    {
        return $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * log with level of notice
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logNotice($message, array $context = [])
    {
        return $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * log with level of info
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logInfo($message, array $context = [])
    {
        return $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * log with level of info
     *
     * @param  string $message
     * @param  array  $context
     *
     * @return void
     */
    public function logDebug($message, array $context = [])
    {
        return $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * get logger instance
     *
     * @return Psr\Log\LoggerInterface
     */
    protected function getLogger() : LoggerInterface
    {
        return app(LoggerInterface::class);
    }
}

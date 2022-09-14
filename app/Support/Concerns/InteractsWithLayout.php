<?php
/**
 * trait class for html title
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Concerns;

trait InteractsWithLayout
{
    /**
     * set html title
     *
     * @param  string $title
     *
     * @return void
     */
    public function setTitle(string $title) : void
    {
        app('view')->share(['title' => $title]);
    }

    /**
     * disable layout main wrapper
     *
     * @return void
     */
    public function disableMainWrapper() : void
    {
        app('view')->share(['disableMainWrapper' => true]);
    }

    /**
     * set html meta keywords
     *
     * @param  string|null $metaDescription
     *
     * @return void
     */
    public function setMetaDescription($metaDescription): void
    {
        app('view')->share(['metaDescription' => $metaDescription]);
    }

    /**
     * set html meta keywords
     *
     * @param  string|null $metaKeywords
     *
     * @return void
     */
    public function setMetaKeywords($metaKeywords): void
    {
        app('view')->share(['metaKeywords' => $metaKeywords]);
    }
}

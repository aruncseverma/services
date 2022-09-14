<?php
/**
 * locale class
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Locale;

class Locale
{
    /**
     * get locale
     *
     * @var string
     */
    public $locale;

    /**
     * locale name
     *
     * @var string
     */
    public $name;

    /**
     * locale request path
     *
     * @var string
     */
    public $path;

    /**
     * locale country code (usable for flag icon)
     *
     * @var string
     */
    public $countryCode;

    /**
     * create instance
     *
     * @param string $locale
     * @param string $name
     * @param string $path
     */
    public function __construct(string $locale, string $name, string $path, string $countryCode)
    {
        $this->locale = $locale;
        $this->name   = $name;
        $this->path   = $path;
        $this->countryCode = $countryCode;
    }
}

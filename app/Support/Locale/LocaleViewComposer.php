<?php
/**
 * view composer class for locale template
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Locale;

use Illuminate\Http\Request;
use App\Support\Locale\Locale;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\Support\Locale\Middleware\SwitchLocale;

class LocaleViewComposer
{
    /**
     * current application locale
     *
     * @var string
     */
    protected $locale;

    /**
     * config repository instance
     *
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * laravel request instance
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * create instance
     *
     * @param Illuminate\Foundation\Application $application
     * @param Illuminate\Config\Repository      $config
     * @param Illuminate\Http\Request           $request
     */
    public function __construct(Application $application, Repository $config, Request $request)
    {
        $this->locale = $application->getLocale();
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * compose view
     *
     * @param  Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view) : void
    {
        $view->with('locales', $this->getLocales());
        $view->with('locale', $this->getSelectedLocale());
    }

    /**
     * get locales array
     *
     * @return Illuminate\Support\Collection
     */
    protected function getLocales() : Collection
    {
        $locales = [];

        foreach ($this->config->get('app.locales', []) as $locale => $option) {
            if ($this->locale !== $locale) {
                $path = $this->getLocalePath($locale);
                $locales[] = new Locale($locale, $option['name'], $path, $option['country_code']);
            }
        }

        return new Collection($locales);
    }

    /**
     * get locale request path for switching to new locale
     *
     * @param  string $locale
     *
     * @return string
     */
    protected function getLocalePath(string $locale) : string
    {
        $queries = array_merge($this->request->query(), [SwitchLocale::LOCALE_KEY => $locale]);

        return $this->request->fullUrlWithQuery($queries);
    }

    /**
     * get current selected locale
     *
     * @return App\Support\Locale
     */
    protected function getSelectedLocale() : Locale
    {
        $option = $this->config->get("app.locales.{$this->locale}");

        return new Locale(
            $this->locale,
            $option['name'],
            $this->getLocalePath($this->locale),
            $option['country_code']
        );
    }
}

<?php
/**
 * middleware class for switch locale using `locale` query parameter
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Support\Locale\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Repository\LanguageRepository;
use Illuminate\Foundation\Application;
use Illuminate\Session\SessionManager;

class SwitchLocale
{
    /**
     * locale key
     *
     * @const
     */
    const LOCALE_KEY = 'locale';

    /**
     * laravel application instance
     *
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * language repository
     *
     * @var App\Repository\LanguageRepository
     */
    protected $repository;

    /**
     * session manager instance
     *
     * @var Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * create instance
     *
     * @param Illuminate\Foundation\Application $app
     * @param App\Repository\LanguageRepository $repository
     * @param Illuminate\Session\SessionManager $session
     */
    public function __construct(Application $app, LanguageRepository $repository, SessionManager $session)
    {
        $this->app = $app;
        $this->repository = $repository;
        $this->session = $session;
    }

    /**
     * handle incoming request
     *
     * @param  Illuminate\Http\Request $request
     * @param  Closure                 $next
     *
     * @return void
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has(static::LOCALE_KEY)) {
            $this->switchLocale($request->query(static::LOCALE_KEY));
        } elseif ($this->session->has(static::LOCALE_KEY)) {
            $this->switchLocale($this->session->get(static::LOCALE_KEY));
        }

        return $next($request);
    }

    /**
     * switch locale
     *
     * @param  string $locale
     *
     * @return void
     */
    protected function switchLocale($locale) : void
    {
        $language = $this->repository->findByCode($locale);

        if ($language && $language->isActive()) {
            // set app locale
            $this->app->setLocale($locale);
            // store to session
            $this->session->put(static::LOCALE_KEY, $locale);
        }
    }
}

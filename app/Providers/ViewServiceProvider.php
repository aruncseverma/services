<?php
/**
 * view service provider for view services
 *
 * @author Mike Alvarez <michaeljpalvarez@gmail.com>
 */

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * composer classes to be registered
     *
     * @var array
     */
    protected $composerClasses = [
        'Admin::common.sidebar' =>  'App\Support\Sidebar\SidebarViewComposer',
        'Admin::common.topbar'  =>  'App\Support\Topbar\TopbarViewComposer',
        'Admin::common.form.country' => 'App\Support\Form\Select\CountryViewComposer',
        'Admin::common.form.continent' => 'App\Support\Form\Select\ContinentViewComposer',
        'Admin::common.form.states' => 'App\Support\Form\Select\StateViewComposer',
        'Admin::common.form.cities' => 'App\Support\Form\Select\CityViewComposer',
        'Admin::common.form.roles' => 'App\Support\Form\Select\RolesViewComposer',
        'Admin::common.form.status' => 'App\Support\Form\Select\StatusViewComposer',
        'Admin::common.form.biller' => 'App\Support\Form\Select\BillerViewComposer',
        'Admin::common.form.currency' => 'App\Support\Form\Select\CurrencyViewComposer',
        'Admin::posts.tags.components.select_tags' => 'App\Support\Post\TagViewComposer',
        'pagination::*' => 'App\Support\Pagination\LimitSelectorComposer',
        'EscortAdmin::common.sidebar' => 'App\Support\Sidebar\SidebarViewComposer',
        'EscortAdmin::common.topbar'  => 'App\Support\Topbar\TopbarViewComposer',
        'EscortAdmin::common.locales' => 'App\Support\Locale\LocaleViewComposer',
        'EscortAdmin::common.form.continent' => 'App\Support\Form\Select\ContinentViewComposer',
        'EscortAdmin::common.form.states' => 'App\Support\Form\Select\StateViewComposer',
        'EscortAdmin::common.form.country' => 'App\Support\Form\Select\CountryViewComposer',
        'EscortAdmin::common.form.cities' => 'App\Support\Form\Select\CityViewComposer',
        'AgencyAdmin::common.sidebar' => 'App\Support\Sidebar\SidebarViewComposer',
        'AgencyAdmin::common.topbar'  => 'App\Support\Topbar\TopbarViewComposer',
        'AgencyAdmin::common.locales' => 'App\Support\Locale\LocaleViewComposer',
        'AgencyAdmin::common.form.continent' => 'App\Support\Form\Select\ContinentViewComposer',
        'AgencyAdmin::common.form.states' => 'App\Support\Form\Select\StateViewComposer',
        'AgencyAdmin::common.form.country' => 'App\Support\Form\Select\CountryViewComposer',
        'AgencyAdmin::common.form.cities' => 'App\Support\Form\Select\CityViewComposer',
        'MemberAdmin::common.sidebar' => 'App\Support\Sidebar\SidebarViewComposer',
        'MemberAdmin::common.topbar'  => 'App\Support\Topbar\TopbarViewComposer',
        'MemberAdmin::common.locales' => 'App\Support\Locale\LocaleViewComposer',
        'MemberAdmin::common.form.continent' => 'App\Support\Form\Select\ContinentViewComposer',
        'MemberAdmin::common.form.states' => 'App\Support\Form\Select\StateViewComposer',
        'MemberAdmin::common.form.country' => 'App\Support\Form\Select\CountryViewComposer',
        'MemberAdmin::common.form.cities' => 'App\Support\Form\Select\CityViewComposer',
        'Index::common.form.country' => 'App\Support\Form\Select\CountryViewComposer',
        'Index::common.form.continent' => 'App\Support\Form\Select\ContinentViewComposer',
        'Index::common.form.states' => 'App\Support\Form\Select\StateViewComposer',
        'Index::common.form.cities' => 'App\Support\Form\Select\CityViewComposer',
        'Index::posts.components.posts' => 'App\Support\Post\PostListViewComposer',
        'Index::posts.components.post' => 'App\Support\Post\PostViewComposer',
        'Index::posts.components.latest_posts' => 'App\Support\Post\PostLatestViewComposer',
        'Index::posts.components.comments.list' => 'App\Support\Post\CommentListViewComposer',
        'Index::posts.components.comments' => 'App\Support\Post\CommentViewComposer',
        'Index::posts.components.latest_comments' => 'App\Support\Post\CommentLatestViewComposer',
        'Index::posts.components.used_categories' => 'App\Support\Post\CategoryViewComposer',
        'Index::pages.components.page_nav' => 'App\Support\Post\PageNavigationViewComposer',
    ];

    /**
     * register services
     *
     * @return void
     */
    public function register() : void
    {
        // register view namespaces
        $this->registerViewNamespaces();
    }

    /**
     * boot services
     *
     * @return void
     */
    public function boot() : void
    {
        // change default pagination view
        LengthAwarePaginator::defaultView('pagination::default');

        // register view composers
        $this->bootViewComposers();

        // boot directives
        $this->bootBladeDirectives();

        // global variables
        $this->getViewFactory()->share('noImageUrl', asset('assets/theme/admin/default/images/no-image.png'));
    }

    /**
     * get instance of view factory
     *
     * @return Illuminate\Contracts\View\Factory
     */
    protected function getViewFactory() : Factory
    {
        return $this->app->make('view');
    }

    /**
     * register view filepath namespace
     *
     * @return void
     */
    protected function registerViewNamespaces() : void
    {
        $this->getViewFactory()->addNamespace('Index', resource_path('views/index'));
        $this->getViewFactory()->addNamespace('Admin', resource_path('views/admin'));
        $this->getViewFactory()->addNamespace('EscortAdmin', resource_path('views/escort_admin'));
        $this->getViewFactory()->addNamespace('AgencyAdmin', resource_path('views/agency_admin'));
        $this->getViewFactory()->addNamespace('Common', resource_path('views/common'));
        $this->getViewFactory()->addNamespace('MemberAdmin', resource_path('views/member_admin'));
    }

    /**
     * register composer classes
     *
     * @return void
     */
    protected function bootViewComposers() : void
    {
        foreach ($this->composerClasses as $path => $composer) {
            $this->getViewFactory()->composer($path, $composer);
        }
    }

    /**
     * boot blade directives
     *
     * @return void
     */
    protected function bootBladeDirectives() : void
    {
        $this->bootAssetStackDirective();
    }

    /**
     * boot asset stack blade directive
     *
     * @return void
     */
    protected function bootAssetStackDirective() : void
    {
        // register instance
        $this->app->singleton('assets.stack', \App\Support\Assets\Stack::class);

        Blade::directive('pushAssets', function ($expression) {
            return "<?php app('assets.stack')->startPush({$expression}); ?>";
        });

        Blade::directive('endPushAssets', function () {
            return "<?php app('assets.stack')->endPush(); ?>";
        });

        Blade::directive('stackAssets', function ($expression) {
            return "<?php echo app('assets.stack')->yieldStack({$expression}); ?>";
        });
    }
}

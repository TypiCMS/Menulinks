<?php
namespace TypiCMS\Modules\Menulinks\Providers;

use Config;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Menulinks\Models\Menulink;
use TypiCMS\Modules\Menulinks\Repositories\CacheDecorator;
use TypiCMS\Modules\Menulinks\Repositories\EloquentMenulink;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkFormLaravelValidator;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Add dirs
        View::addNamespace('menulinks', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'menulinks');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/menulinks'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Menulinks\Providers\RouteServiceProvider');

        $app->bind('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface', function (Application $app) {
            $repository = new EloquentMenulink(new Menulink);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'menulinks', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm', function (Application $app) {
            return new MenulinkForm(
                new MenulinkFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')
            );
        });
    }
}

<?php
namespace TypiCMS\Modules\Menulinks\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Menulinks\Models\Menulink;

// Repo
use TypiCMS\Modules\Menulinks\Repositories\EloquentMenulink;

// Cache
use TypiCMS\Modules\Menulinks\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
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

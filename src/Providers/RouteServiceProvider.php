<?php
namespace TypiCMS\Modules\Menulinks\Providers;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Menulinks\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('menulinks', 'TypiCMS\Modules\Menulinks\Models\Menulink');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {
            /**
             * Admin routes
             */
            $router->resource('admin/menus.menulinks', 'AdminController');
            $router->post(
                'admin/menulinks/sort',
                ['as' => 'admin.menulinks.sort', 'uses' => 'AdminController@sort']
            );

            /**
             * API routes
             */
            $router->resource('api/menulinks', 'ApiController');
        });
    }

}

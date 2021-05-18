<?php

namespace Navari\LaraDeploy;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaraDeployServiceProvider
{

    public function boot() {
        $this->registerResources();

        // register views path (for email notification)
        $this->loadViewsFrom(__DIR__.'./resources/views/', 'laradeploy');

        // register routes for web hooks.
        $this->registerRoutes();
    }

    public function register()
    {
        //
    }

    /**
     * publish configuration file, and sample deployment script.
     */
    public function registerResources()
    {
        $this->publishes([
            __DIR__.'./config/laradeploy.php' => config_path('laradeploy.php')
        ], 'laradeploy');
        $this->publishes([
            __DIR__.'./laradeploy.sh' => base_path('laradeploy.sh')
        ], 'laradeploy');
    }

    /**
     * Register package routes - github and bitbucket web hook route handler.
     */
    protected function registerRoutes()
    {
        Route::group(['namespace' => 'Navari\LaraDeploy\Http\Controllers'], function() {
            $this->loadRoutesFrom(__DIR__.'./routes/web.php');
        });
    }

}
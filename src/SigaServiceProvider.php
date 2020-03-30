<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use Illuminate\Support\ServiceProvider;
use SIGA\Providers\MacrosServiceProvider;
use SIGA\Providers\SigaRouteServiceProvider;

class SigaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(MacrosServiceProvider::class);

        $this->app->register(SigaRouteServiceProvider::class);

        $this->mergeConfigFrom(siga_path('config\\siga.php'),'siga');

        $this->loadMigrationsFrom(siga_path('database/migrations'));

        $this->loadViewsFrom(siga_path('resources/views/callcocam/siga'),'siga');


    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/siga.php' => config_path('siga.php'),
        ]);

        $this->publishes([
            __DIR__.'/resources' => resource_path(),
        ]);
        $this->publishes([
            __DIR__.'/assets' => public_path('vendor'),
        ], 'public');
    }
}

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

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/callcocam/siga'),
        ]);

    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

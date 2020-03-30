<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Providers;

use Illuminate\Support\ServiceProvider;

class SigaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        include dirname(__DIR__,2)."/helper.php";

        $this->app->register(MacrosServiceProvider::class);

        $this->app->register(SigaRouteServiceProvider::class);

        $this->mergeConfigFrom(siga_path('config\\siga.php'),'siga');

        $this->loadMigrationsFrom(siga_path('database/migrations'));

        $this->loadViewsFrom(siga_path('resources/views'),'siga');


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

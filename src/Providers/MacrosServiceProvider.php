<?php


namespace SIGA\Providers;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider  extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Doctrine\DBAL\DBALException
     */
    public function boot()
    {
        \Schema::defaultStringLength('255');
        $platform = \Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        $this->bluePrintMacros();
    }


    public function bluePrintMacros()
    {
        Blueprint::macro('myId', function($name="id"){
            $this->uuid($name)->primary();
        });

        Blueprint::macro('tenant', function($name="company_id"){
            $this->uuid($name)->nullable();
            $this
                ->foreign($name)
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Blueprint::macro('user', function($name="user_id"){
            $this->uuid($name)->nullable();
            $this
                ->foreign($name)
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Blueprint::macro('status', function($status =[]){
            $this->enum('status', array_merge([  'deleted','draft','published'], $status))->default('published');
        });

    }
}

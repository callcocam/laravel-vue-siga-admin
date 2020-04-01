<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Tenant;

use SIGA\Tenant\Facades\Tenant;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class TenantServiceProvider extends ServiceProvider
{

    private $company;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                realpath(__DIR__.'/../config/landlord.php') => config_path('landlord.php'),
            ]);
        }

        try {
            $this->company = \DB::table('companies')->where('assets', request()->getHost())->first();

            $tenant = null;

            if (!$this->company) :
                $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();

                \DB::table('companies')->insert([
                    [
                        'id' => $uuid,
                        'company_id' => $uuid,
                        'name' => "SIGA SMART SISTEMAS",
                        'slug' => Str::slug("SIGA SMART SISTEMAS"),
                        'email' => "contato@sigasmart.com.br",
                        'description' =>"Sistema integrado de gerenciamento e administração!!",
                        'assets' => request()->getHost(),
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s"),
                    ]
                ]);

               // die(response("Nenhuma empresa cadastrada com esse endereço " . str_replace("admin.", "", request()->getHost()), 401));
                $this->company = \DB::table('companies')->where('assets', request()->getHost())->first();
            endif;

            $tenant = $this->company->id;

            Tenant::addTenant("company_id", $tenant);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TenantManager::class, function () {
            return new TenantManager();
        });
    }
}

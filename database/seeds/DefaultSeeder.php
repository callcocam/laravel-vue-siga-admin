<?php

use App\Tenant\Facades\Tenant;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        Tenant::addTenant("company_id", $uuid);
        factory(\App\Company::class)->create([
            'id' => $uuid,
            'company_id' => $uuid,
            'assets' => "localhost.crm-01.test",
            'email' => "tenant@localhost.crm-01.test"
        ])->each(function ($company){
            $company->file()->create(factory(\App\File::class)->make()->toArray());
        });
        Tenant::addTenant("company_id", $uuid);
        $this->addroles([
            'name' => "Super Admin 01",
            'email' => "admin@localhost.crm-01.test"
        ]);

        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        Tenant::addTenant("company_id", $uuid);
        factory(\App\Company::class)->create([
            'id' => $uuid,
            'company_id' => $uuid,
            'assets' => "localhost.crm-02.test",
            'email' => "tenant@localhost.crm-02.test"
        ])->each(function ($company){
            $company->file()->create(factory(\App\File::class)->make()->toArray());
        });

        Tenant::addTenant("company_id", $uuid);
        $this->addroles([
            'name' => "Super Admin 02",
            'email' => "admin@localhost.crm-02.test"
        ]);

        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        factory(\App\Company::class)->create([
            'id' => $uuid,
            'company_id' => $uuid,
            'assets' => "localhost.crm-03.test",
            'email' => "tenant@localhost.crm-03.test"
        ])->each(function ($company){
            $company->file()->create(factory(\App\File::class)->make()->toArray());
        });
        Tenant::addTenant("company_id", $uuid);
        $this->addroles([
            'name' => "Super Admin 03",
            'email' => "admin@localhost.crm-03.test"
        ]);


    }

    protected function addroles($data){

        factory(\App\Suports\Shinobi\Models\Role::class)->create([
            'name'=>'Super Admin',
            'slug'=>'uper-admin',
            'special'=>'all-access'
        ])->each(function ($role) use ($data){
            $this->users(1,$role,$data);
        });

        factory(\App\Suports\Shinobi\Models\Role::class)->create([
            'name'=>'Gerente',
            'slug'=>'gerente',
            'special'=>null,
            'description'=>'Consegue fazer todas as operações no sistema',
        ])->each(function ($role){
            $this->users(1,$role);
        });

        factory(\App\Suports\Shinobi\Models\Role::class)->create([
            'name'=>'Funcionário',
            'slug'=>'funcionario',
            'special'=>null,
            'description'=>'Consegue visualizar eventos',
        ])->each(function ($role)  {
            $this->users(5,$role);
        });

        factory(\App\Suports\Shinobi\Models\Role::class)->create([
            'name'=>'Cliente',
            'slug'=>'cliente',
            'special'=>null,
            'description'=>'Consegue fazer pedidos, acompanhar pedidos ',
        ])->each(function ($role) {
            $this->users(10,$role);
        });
    }

    private function users($amount,$role,$data=[]){
        factory(\App\User::class,$amount)->create($data)->each(function ($user) use ($role){
            $user->address()->save(factory(\App\Addres::class)->make());
            $user->file()->save(factory(\App\File::class)->make());
            $role->user_id = $user->id;
            $role->update();
            $user->roles()->sync($role);
            //$this->blog($user);
           Artisan::call("make:permissions");
        });
    }


}

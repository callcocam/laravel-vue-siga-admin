<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {

       $this->call(DefaultSeeder::class);
        //$this->call(BlogSeeder::class);
    }

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
                $table->myId();
                $table->tenant();
                $table->user();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('zip', 20)->nullable();
                $table->string('city')->nullable();
                $table->string('state', 3)->nullable();
                $table->string('country', 50)->default("BRASIL")->nullable();
                $table->string('street')->nullable();
                $table->string('district')->nullable();
                $table->string('number', 10)->nullable();
                $table->string('complement')->nullable();
                $table->uuidMorphs('addresable');
                $table->status();
                $table->softDeletes();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}

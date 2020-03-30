<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSigaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->myId();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string("fantasy")->nullable();
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->string('document', 50)->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender',['male','female'])->default('male')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('description')->nullable();
            $table->status();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

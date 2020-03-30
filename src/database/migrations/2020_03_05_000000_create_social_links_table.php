<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *'twitter','facebook','instagram','github','linkedin','codepen', 'slack','youtub','google','website'
     * @return void
     */
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->myId();
            $table->tenant();
            $table->user();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('codepen')->nullable();
            $table->string('slack')->nullable();
            $table->string('youtub')->nullable();
            $table->string('google')->nullable();
            $table->string('website')->nullable();
            $table->uuidMorphs('social_linkable');
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
        Schema::dropIfExists('social_links');
    }
}

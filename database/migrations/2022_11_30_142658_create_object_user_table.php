<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_user', function (Blueprint $table) {
            $table->uuid('object_id');
            $table->foreign('object_id')->references('id')->on('objects');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['object_id','user_id']);
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
        Schema::dropIfExists('object_user');
    }
}

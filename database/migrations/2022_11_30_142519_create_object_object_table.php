<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_object', function (Blueprint $table) {
            $table->uuid('object1_id');
            $table->foreign('object1_id')->references('id')->on('objects');
            $table->uuid('object2_id');
            $table->foreign('object2_id')->references('id')->on('objects');
            $table->primary(['object1_id','object2_id']);
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
        Schema::dropIfExists('object_object');
    }
}

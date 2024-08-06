<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_group', function (Blueprint $table) {
            $table->uuid('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->uuid('message_id');
            $table->foreign('message_id')->references('id')->on('messages');
            $table->primary(['group_id','message_id']);
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
        Schema::dropIfExists('message_group');
    }
}

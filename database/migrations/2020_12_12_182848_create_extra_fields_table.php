<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_fields', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('description');
            $table->string('type_value');
            $table->string('type');

            $table->uuid('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');

            $table->uuid('master_extra_field')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('extra_fields', function($table) {
            $table->foreign('master_extra_field')->references('id')->on('extra_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_fields');
    }
}

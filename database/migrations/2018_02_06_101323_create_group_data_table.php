<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_data', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ad_id')->length(10)->unsigned()->nullable();
            $table->integer('group_id')->length(10)->unsigned()->nullable();
            $table->integer('group_field_id')->length(10)->unsigned()->nullable();

            $table->string('column_name')->nullable();
            $table->text('column_value')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_data');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_data', function (Blueprint $table) {
            $table->increments('cf_data_id');

            $table->integer('ad_id')->length(10)->unsigned()->nullable();
            $table->integer('cf_id')->length(10)->unsigned()->nullable();

            $table->string('column_name', 150)->nullable();
            $table->text('column_value')->nullable();
            $table->text('type')->nullable();
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
        Schema::dropIfExists('custom_field_data');
    }
}

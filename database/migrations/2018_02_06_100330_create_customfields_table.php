<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customfields', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('options')->nullable();
            $table->text('description')->nullable();
            $table->string('user_type')->nullable();
            $table->string('data_type',50)->nullable();

            $table->string('inscription')->nullable();

            $table->tinyInteger('is_shown')->nullable()->unsigned();
            $table->tinyInteger('required_field')->nullable()->unsigned();

            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->tinyInteger('search')->nullable()->unsigned();
            $table->tinyInteger('status')->nullable()->unsigned();
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
        Schema::dropIfExists('customfields');
    }
}

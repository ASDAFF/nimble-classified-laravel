<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->length(10)->unsigned()->nullable();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->tinyInteger('status')->nullable()->unsigned()->default(1);
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
        Schema::dropIfExists('group_fields');
    }
}

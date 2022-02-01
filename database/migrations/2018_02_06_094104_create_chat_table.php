<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
        $table->increments('id');
        $table->string('identifier', 250)->nullable();
        $table->integer('from')->length(10)->nullable()->unsigned();
        $table->integer('to')->length(10)->nullable()->unsigned();
        $table->text('text')->nullable();
        $table->string('user_type', 5)->nullable();
        $table->tinyInteger('is_checked')->nullable()->unsigned()->default(0);
        $table->tinyInteger('is_notify')->nullable()->unsigned()->default(0);
        $table->tinyInteger('status')->unsigned()->default(0);
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
        Schema::dropIfExists('chat');
    }
}

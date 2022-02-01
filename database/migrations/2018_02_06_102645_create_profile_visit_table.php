<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_visit', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->length(10)->unsigned()->nullable();
            $table->integer('ads_view')->length(11)->unsigned()->nullable();
            $table->integer('profile_view')->length(10)->unsigned()->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('profile_visit');
    }
}

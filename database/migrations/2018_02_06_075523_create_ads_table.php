<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->length(10)->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('category_id')->length(10)->nullable()->unsigned();
            $table->integer('region_id')->length(10)->nullable()->unsigned();
            $table->integer('city_id')->length(10)->nullable()->unsigned();
            $table->string('address')->nullable();
            $table->integer('price')->length(10)->nullable()->unsigned();
            $table->string('price_option')->nullable();
            $table->string('zip')->nullable();
            $table->tinyInteger('show_email')->nullable()->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->integer('visit')->length(10)->nullable()->unsigned()->default(0);
            $table->integer('message')->length(10)->nullable()->unsigned();
            $table->tinyInteger('is_img')->nullable()->unsigned();
            $table->tinyInteger('is_login')->nullable()->unsigned();
            $table->string('unique')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('f_type')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at');
        });
    }
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}

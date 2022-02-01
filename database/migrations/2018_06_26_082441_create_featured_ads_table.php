<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description');
            $table->integer('normal_listing_price')->length(10)->unsigned()->nullable();
            $table->integer('home_page_price')->length(10)->unsigned()->nullable();
            $table->integer('home_page_days')->length(10)->unsigned()->nullable();
            $table->integer('top_page_price')->length(10)->unsigned()->nullable();
            $table->integer('top_page_days')->length(10)->unsigned()->nullable();
            $table->integer('urgent_price')->length(10)->unsigned()->nullable();
            $table->integer('urgent_days')->length(10)->unsigned()->nullable();
            $table->integer('urgent_top_price')->length(10)->unsigned()->nullable();
            $table->integer('urgent_top_days')->length(10)->unsigned()->nullable();
            $table->tinyInteger('status')->length(1)->unsigned();
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
        Schema::dropIfExists('featured_ads');
    }
}

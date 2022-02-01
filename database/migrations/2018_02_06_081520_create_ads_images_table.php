<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_images', function (Blueprint $table) {
            $table->increments('id');

         $table->integer('ad_id')->length(10)->nullable()->unsigned();
         $table->string('orignal_filename', 500)->nullable();
         $table->string('image', 500)->nullable();
         $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('ads_images');
    }
}

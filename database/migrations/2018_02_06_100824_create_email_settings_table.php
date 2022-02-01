<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->length(10)->nullable();
            $table->string('registration_subject')->nullable();
            $table->text('registration_content')->nullable();
            $table->string('status_subject')->nullable();
            $table->text('status_content')->nullable();

            $table->string('verify_success_subject')->nullable();
            $table->text('verify_success_content')->nullable();

            $table->string('verify_danger_subject')->nullable();
            $table->text('verify_danger_content')->nullable();
            /* ver 1.7 added */
            $table->string('expiry_ads_subject')->nullable();
            $table->text('expiry_ads_content')->nullable();

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
        Schema::dropIfExists('email_settings');
    }
}

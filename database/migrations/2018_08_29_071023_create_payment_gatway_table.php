<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentGatwayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gatway', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stripe_publishable_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->tinyInteger('stripe_status')->default(1);

            $table->string('paypal_email')->nullable();
            $table->tinyInteger('paypal_status')->default(1);

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
        Schema::dropIfExists('payment_gatway');
    }
}

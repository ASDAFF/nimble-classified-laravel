<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
Use App\Session;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email', 191)->unique();
                $table->string('password');

                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('telephone')->nullable();
                $table->enum('type', ['u', 'adm', 'c']);
                $table->string('image')->nullable();
                $table->integer('region_id')->length(10)->nullable()->unsigned();
                $table->integer('city_id')->length(10)->nullable()->unsigned();
                $table->integer('comune_id')->length(10)->nullable()->unsigned();
                $table->string('address')->nullable();
                $table->string('zip')->nullable();
                $table->string('vat')->nullable();
                $table->enum('gender', ['f', 'm'])->nullableunsigned();
                $table->string('plain_password');
                $table->tinyInteger('is_login')->nullable()->unsigned();
                $table->longText('id_card')->nullable();
                $table->tinyInteger('is_verified')->nullable()->unsigned();
                $table->tinyInteger('chat_lock')->nullable()->unsigned();
                $table->tinyInteger('status')->default(1);
                $table->tinyInteger('mobile_verify')->nullable()->unsigned();
                $table->tinyInteger('email_verify')->default(0);
                $table->timestamp('login_update')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            // add amin data
            $now = DB::raw('NOW()');
            DB::table('users')->insert(
                [
                    'name' => \Session::get('admin_name'),
                    'email' => \Session::get('admin_email'),
                    'password' =>  bcrypt(\Session::get('admin_password')),
                    'plain_password' => \Session::get('admin_password'),
                    'type' => 'adm',
                    'status' => 1,
                    'email_verify' => 1,
                    'created_at' => $now
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

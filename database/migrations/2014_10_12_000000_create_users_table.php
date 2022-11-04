<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->nullable();
            $table->string('email', 190)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('personal_number', 190)->unique()->nullable();
            $table->string('postcode')->nullable();
            $table->string('city_town')->nullable();
            $table->string('unicard')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('mobile_token')->nullable();
            $table->double('balance')->default(0);
            $table->integer('roles')->default(0);
            $table->integer('newsletter')->default(0);
            $table->integer('email_verified')->default(0); //not verified
            $table->string('email_token')->default(0); //not verified
            $table->integer('email_verification_count')->default(0); //not verified
            $table->boolean('temp')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

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

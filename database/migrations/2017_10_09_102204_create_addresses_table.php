<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->string('address_1_en');
            $table->string('address_1_ka');
            $table->string('address_2_en')->nullable();
            $table->string('address_2_ka')->nullable();
            $table->string('city_en');
            $table->string('city_ka');
            $table->string('state_en');
            $table->string('state_ka');
            $table->string('zip');
            $table->string('phone');

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
        Schema::dropIfExists('addresses');
    }
}

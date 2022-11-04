<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('sender_id')->nullable();
            $table->integer('trusted_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->integer('type')->default(0);
            $table->string('status')->default('waiting');
            $table->boolean('home_delivery')->default(false);
            $table->integer('operator_id')->nullable(); //if empty added by user
            $table->integer('from_country_id');
            $table->integer('to_country_id');
            $table->boolean('deny')->default(false);
            $table->double('parcel_cost')->nullable();
            $table->double('delivery_cost')->nullable();
            $table->double('unicard_amount')->nullable();
            $table->boolean('paid')->default(false);
            $table->double('weight')->nullable();
            $table->double('obtain_cost')->nullable();
            $table->string('obtain_currency')->default('GBP');
            $table->string('obtain_invoice')->nullable(); // client adds when declaring image url goes here
            $table->string('obtain_webstore')->nullable();
            $table->text('obtain_categories')->nullable();
            $table->string('xero_invoice_for')->nullable();
            $table->string('xero_invoice_number')->nullable();
            $table->string('xero_payment_url')->nullable();
            $table->string('xero_guid')->nullable();
            $table->integer('declared')->default(0);
            $table->text('comment')->nullable();
            $table->date('arrive_date')->nullable();
            $table->timestamps();
            $table->foreign("user_id")
                  ->references("id")->on("users")
                  ->onDelete('cascade');

//            $table->unique(['','']);
//            $table->index(['','','']);
//            $table->foreign("trusted_user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

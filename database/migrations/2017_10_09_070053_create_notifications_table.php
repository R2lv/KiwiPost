<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title_en')->nullable();
            $table->string('title_ka')->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_ka')->nullable();
            $table->string('button_text_en')->nullable();
            $table->string('button_text_ka')->nullable();
            $table->string('button_action')->nullable();
            $table->string('button_url')->nullable();
            $table->string('button_2_text_en')->nullable();
            $table->string('button_2_text_ka')->nullable();
            $table->string('button_2_action')->nullable();
            $table->string('button_2_url')->nullable();
            $table->integer('button_close')->default(0);
            $table->string('type')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}

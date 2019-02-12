<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class GiftCardsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_cards', function (Blueprint $table) {
            // auto increment id (primary key)
            $table->increments('id');
            $table->string('uuid');
            $table->decimal('balance', 8, 2);

            $table->timestamps();
            $table->softDeletes();  //It is not really deleted, just marked as deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gift_cards');
    }
}

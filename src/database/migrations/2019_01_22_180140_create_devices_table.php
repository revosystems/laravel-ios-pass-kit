<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('wallet.devices_table', 'devices'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_library_identifier');
            $table->string(config('wallet.apn_token_field', 'token'));
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
        Schema::dropIfExists(config('wallet.devices_table', 'devices'));
    }
}
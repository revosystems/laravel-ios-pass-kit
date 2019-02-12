<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassKitTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('passKit.devices_table', 'devices'), function (Blueprint $table) {
            $table->increments('id');
            $table->string(config('passKit.apn_token_field', 'token'));
            $table->string('device_library_identifier');
            $table->unique('uuid', 'device_library_identifier');
            $table->timestamps();
        });

        Schema::create('pass_kit_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pass_kit_device_id')->unsigned();
            $table->integer('pass_kit_registration_id')->unsigned();
            $table->string('pass_kit_registration_type');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table(config('passKit.businessTable'), function (Blueprint $table) {
            $table->longText('passes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pass_kit_registrations');
        Schema::dropIfExists(config('passKit.devices_table', 'devices'));
    }
}

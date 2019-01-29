<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassKitRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_kit_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pass_kit_device_id')->unsigned();
            $table->integer('pass_kit_registration_id')->unsigned();
            $table->string('pass_kit_registration_type');
            $table->timestamps();
            $table->softDeletes();
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
    }
}

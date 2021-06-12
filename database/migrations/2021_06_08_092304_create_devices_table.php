<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string("app_id", 255);
            $table->string("device_id", 255);
            $table->string("language", 255);
            $table->string("operating_system", 255);
            $table->string("client_token", 255);
            $table->string('os_username');
            $table->string('os_password');
            $table->timestamps();
            
            $table->index(["app_id", "device_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}

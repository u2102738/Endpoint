<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('id')->on('devices');
            $table->string('client', 24);
            $table->string('asset_owner', 24);
            $table->string('name');
            $table->string('OS_Version');
            $table->string('vendor');
            $table->string('serial_number');
            $table->string('domain');
            $table->string('system_family');
            $table->string('version');
            $table->string('network_info');
            $table->boolean('erp_owner');
            $table->text('info')->nullable();
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
        Schema::dropIfExists('hardware');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_category_id');
            $table->foreignId('lab_id');
            $table->string('name');
            $table->string('model_number');
            $table->string('serial_number');
            $table->longText('description');
            $table->string('operating_status');
            $table->integer('per_hour_cost');
            $table->integer('minimum_booking_duration');
            $table->integer('maximum_booking_duration');
            $table->json('photos');
            $table->string('operational_manual')->nullable();
            $table->string('service_manual')->nullable();
            $table->string('video_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instruments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instrument_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id');
            $table->string('service_type')->default('repair')->comment(' repair, maintenance');
            $table->longText('description')->nullable();
            $table->integer('cost')->nullable();
            $table->string('next_service_date')->nullable();
            $table->json('photos')->nullable();
            $table->string('status')->default('pending')->comment('pending, completed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrument_services');
    }
};

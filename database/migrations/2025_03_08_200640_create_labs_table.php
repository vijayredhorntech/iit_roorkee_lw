<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_investigator_id');
            $table->string('lab_image');
            $table->string('lab_name');
            $table->string('department');
            $table->string('building');
            $table->string('floor');
            $table->string('room_number');
            $table->string('type');
            $table->string('contact_number');
            $table->string('working_hours');
            $table->string('capacity')->nullable();
            $table->longText('description')->nullable();
            $table->longText('safety_guidelines')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('labs');
    }
};

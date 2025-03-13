<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instrument_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id');
            $table->foreignId('student_id');
            $table->foreignId('booking_id');
            $table->string('subject');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('pending')->comment('approved, rejected, pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrument_complaints');
    }
};

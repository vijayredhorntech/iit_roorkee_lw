<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id');
            $table->foreignId('student_id');
            $table->foreignId('slot_id');
            $table->date('date');
            $table->longText('description')->nullable();
            $table->string('status')->default('confirmed')->exists(['confirmed', 'cancelled']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};

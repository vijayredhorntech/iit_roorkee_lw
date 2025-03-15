<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instrument_accessories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id');
            $table->string('name');
            $table->string('model_number');
            $table->string('purchase_date');
            $table->string('price');
            $table->string('description');
            $table->string('status')->default('available')->exists(['available', 'notAvailable']);
            $table->string('photo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrument_accessories');
    }
};

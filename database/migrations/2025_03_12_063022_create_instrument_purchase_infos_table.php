<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instrument_purchase_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id');
            $table->string('manufacturer_name');
            $table->string('vendor_name');
            $table->string('manufacturing_date');
            $table->string('purchase_date');
            $table->string('purchase_order_number');
            $table->integer('cost');
            $table->string('funding_source');
            $table->string('installation_date');
            $table->string('warranty_period');
            $table->string('next_service_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrument_purchase_infos');
    }
};

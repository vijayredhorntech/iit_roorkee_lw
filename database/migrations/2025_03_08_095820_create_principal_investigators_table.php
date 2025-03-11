<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('principal_investigators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('department');
            $table->string('designation');
            $table->string('email')->unique();
            $table->string('alt_email')->nullable();
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->text('office_address');
            $table->string('specialization');
            $table->string('qualification');
            $table->string('profile_photo')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('principal_investigators');
    }
};

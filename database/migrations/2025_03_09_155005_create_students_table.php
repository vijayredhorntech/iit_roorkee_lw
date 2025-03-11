<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('principal_investigator_id');
            $table->string('profile_photo');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('academic_id');
            $table->string('department');
            $table->string('year_of_study');
            $table->string('email')->unique();
            $table->string('alt_email');
            $table->string('mobile_number');
            $table->string('research_area');
            $table->longText('address');
            $table->boolean('status')->default(1);            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};

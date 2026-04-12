<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educational_info', function (Blueprint $table) {
            $table->id('educational_info_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('education_level', ['Incoming First Year College', 'College'])->default('College');
            $table->string('school_name');
            $table->enum('semester_type', ['2 Semesters', '3 Semesters'])->default('2 Semesters');
            $table->string('year_level')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educational_info');
    }
};

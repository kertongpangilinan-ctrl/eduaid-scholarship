<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family_info', function (Blueprint $table) {
            $table->id('family_info_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('father_name');
            $table->string('father_occupation')->nullable();
            $table->decimal('father_salary', 12, 2)->nullable();
            $table->date('father_birth_date')->nullable();
            $table->string('mother_name');
            $table->string('mother_occupation')->nullable();
            $table->decimal('mother_salary', 12, 2)->nullable();
            $table->date('mother_birth_date')->nullable();
            $table->integer('total_siblings')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_info');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('educational_info', function (Blueprint $table) {
            $table->enum('current_semester', ['1st Semester', '2nd Semester', '3rd Semester'])->nullable()->after('semester_type');
            $table->string('lrn', 11)->nullable()->after('year_level');
            $table->string('shs_strand')->nullable()->after('lrn');
            $table->string('school_id_type')->nullable()->after('shs_strand');
            $table->string('school_id_number')->nullable()->after('school_id_type');
        });
    }

    public function down(): void
    {
        Schema::table('educational_info', function (Blueprint $table) {
            $table->dropColumn(['current_semester', 'lrn', 'shs_strand', 'school_id_type', 'school_id_number']);
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 20)->unique()->after('name');
            $table->enum('role', ['student', 'admin', 'staff'])->default('student')->after('email');
            $table->enum('account_status', [
                'pending_verification',
                'pending_admin_approval',
                'under_review',
                'requires_action',
                'approved',
                'rejected'
            ])->default('pending_verification')->after('role');
            $table->string('reference_number')->unique()->nullable()->after('account_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role', 'account_status', 'reference_number']);
        });
    }
};

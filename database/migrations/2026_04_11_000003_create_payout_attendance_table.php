<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payout_attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->foreignId('payout_id')->constrained('payout_events', 'event_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('qr_code');
            $table->enum('attendance_type', ['on_time', 'late'])->default('on_time');
            $table->timestamp('scanned_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_attendance');
    }
};

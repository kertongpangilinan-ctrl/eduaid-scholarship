<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payout_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->foreignId('payout_id')->constrained('payouts', 'payout_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('status', ['claimed', 'missed', 'late'])->default('missed');
            $table->timestamp('claimed_at')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_history');
    }
};

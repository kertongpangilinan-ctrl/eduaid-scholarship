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
        Schema::table('payout_attendance', function (Blueprint $table) {
            // Drop the old foreign key
            $table->dropForeign(['payout_id']);
            
            // Add the correct foreign key referencing payout_events
            $table->foreign('payout_id')
                  ->references('event_id')
                  ->on('payout_events')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payout_attendance', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['payout_id']);
            
            // Revert to the old foreign key referencing payouts
            $table->foreign('payout_id')
                  ->references('payout_id')
                  ->on('payouts')
                  ->onDelete('cascade');
        });
    }
};

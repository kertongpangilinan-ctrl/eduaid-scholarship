<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('sent_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['application_status', 'document_verification', 'payout', 'announcement', 'message']);
            $table->boolean('is_read')->default(false);
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

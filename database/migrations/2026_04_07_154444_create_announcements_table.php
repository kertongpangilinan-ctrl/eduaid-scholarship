<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('when_info')->nullable();
            $table->string('where_info')->nullable();
            $table->string('what_info')->nullable();
            $table->enum('announcement_type', ['general', 'scholarship', 'payout', 'event', 'deadline']);
            $table->boolean('is_pinned')->default(false);
            $table->string('image_path')->nullable();
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_chats', function (Blueprint $table) {
            $table->id('group_chat_id');
            $table->string('group_name');
            $table->foreignId('batch_id')->constrained('batches', 'batch_id')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_chats');
    }
};

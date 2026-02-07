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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message')->nullable();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('receiver_id')->constrained('users');
            $table->foreignId('conversation_id')->nullable()->constrained('conversations');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->timestamps();
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('last_message_id')->nullable()->constrained('messages');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('last_message_id')->nullable()->constrained('messages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
            $table->dropColumn('last_message_id');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
            $table->dropColumn('last_message_id');
        });

        Schema::dropIfExists('messages');
    }
};

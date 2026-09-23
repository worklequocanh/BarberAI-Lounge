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
        // 1. AI Conversations
        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('session_id', 64)->nullable()->unique();
            $table->string('title', 255)->nullable();
            $table->string('status', 20)->default('active'); // active, closed
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at'], 'idx_user_created');
        });

        // 2. AI Messages
        Schema::create('ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->string('role', 20); // user, assistant, system
            $table->text('content');
            $table->integer('tokens_used')->default(0);
            $table->string('ai_model', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 3. AI Recommendations
        Schema::create('ai_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->nullable()->constrained('ai_conversations')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('detected_face_shape', 50)->nullable();
            $table->string('hair_type', 50)->nullable();
            $table->json('hairstyle_ids'); // [3, 7, 12]
            $table->json('services_ids')->nullable(); // [1, 2, 5]
            $table->text('ai_reason')->nullable();
            $table->decimal('confidence_score', 4, 2)->nullable();
            $table->string('image_uploaded', 255)->nullable();
            $table->unsignedTinyInteger('feedback_rating')->nullable(); // 1 - 5 stars
            $table->string('feedback_note', 255)->nullable(); // customer feedback notes
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_conversations');
    }
};

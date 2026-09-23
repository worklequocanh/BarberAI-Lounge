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
        // 1. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('icon', 255)->nullable();
            $table->integer('sort')->default(0);
        });

        // 2. Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 0);
            $table->smallInteger('duration_min')->default(30);
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        // 3. Face Shapes
        Schema::create('face_shapes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
        });

        // 4. Hairstyles
        Schema::create('hairstyles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->json('face_shape_ids')->nullable();
            $table->json('hair_types')->nullable();
            $table->json('tags')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        // 5. Pivot: hairstyle_service
        Schema::create('hairstyle_service', function (Blueprint $table) {
            $table->foreignId('hairstyle_id')->constrained('hairstyles')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            $table->primary(['hairstyle_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hairstyle_service');
        Schema::dropIfExists('hairstyles');
        Schema::dropIfExists('face_shapes');
        Schema::dropIfExists('services');
        Schema::dropIfExists('categories');
    }
};

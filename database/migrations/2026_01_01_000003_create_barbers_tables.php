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
        // 1. Barbers
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->unsignedTinyInteger('experience_years')->default(0);
            $table->json('specialties')->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        // 2. Barber schedules
        Schema::create('barber_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barber_id')->constrained('barbers')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0=CN, 1=T2... 6=T7
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_working')->default(true);

            $table->unique(['barber_id', 'day_of_week'], 'uk_barber_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barber_schedules');
        Schema::dropIfExists('barbers');
    }
};

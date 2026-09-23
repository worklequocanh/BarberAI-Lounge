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
        // 1. Appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('barber_id')->nullable()->constrained('barbers')->nullOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->decimal('total_price', 12, 0)->default(0);
            $table->string('status', 20)->default('pending'); // pending, confirmed, in_progress, completed, cancelled, no_show
            $table->string('payment_method', 20)->default('cash'); // cash, momo, vnpay, bank
            $table->string('payment_status', 20)->default('unpaid'); // unpaid, paid, refunded
            $table->text('note')->nullable();
            $table->string('cancel_reason', 255)->nullable();
            $table->foreignId('ai_recommendation_id')->nullable()->constrained('ai_recommendations')->nullOnDelete();
            $table->string('slot_key', 64)->nullable()->unique();
            $table->timestamps();

            $table->index(['customer_id', 'appointment_date'], 'idx_customer_date');
            $table->index(['barber_id', 'appointment_date', 'status'], 'idx_barber_date_status');
        });

        // 2. Appointment Services (Pivot)
        Schema::create('appointment_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->decimal('price', 12, 0);
        });

        // 3. Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->unique()->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('barber_id')->nullable()->constrained('barbers')->nullOnDelete();
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->json('images')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('appointment_services');
        Schema::dropIfExists('appointments');
    }
};

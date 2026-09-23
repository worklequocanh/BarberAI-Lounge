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
        // 1. Cập nhật bảng services (Hỗ trợ Combo & Ưu đãi)
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('is_combo')->default(false)->after('price');
            $table->decimal('original_price', 12, 0)->nullable()->after('is_combo');
            $table->json('combo_items')->nullable()->after('original_price');
        });

        // 2. Cập nhật bảng appointments (Ghi chú kỹ thuật thợ & ảnh chụp kết quả)
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('hair_notes')->nullable()->after('note');
            $table->json('result_photos')->nullable()->after('hair_notes');
        });

        // 3. Cập nhật bảng hairstyles (Đề xuất Combo dịch vụ phù hợp để lên form tóc)
        Schema::table('hairstyles', function (Blueprint $table) {
            $table->foreignId('recommended_combo_id')->nullable()->after('tags')->constrained('services')->nullOnDelete();
        });

        // 4. Bảng quản lý ngày nghỉ / nghỉ phép của thợ cắt tóc
        Schema::create('barber_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barber_id')->constrained('barbers')->cascadeOnDelete();
            $table->date('leave_date');
            $table->string('reason', 255)->nullable();
            $table->string('status', 20)->default('approved'); // approved, pending, rejected
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['barber_id', 'leave_date'], 'uk_barber_leave');
        });

        // 5. Bảng chiến dịch Email Marketing & Tự động hoá
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('subject', 255);
            $table->string('target_audience', 50)->default('all'); // all, vip, inactive_30d, birthday_month
            $table->text('content');
            $table->string('coupon_code', 50)->nullable();
            $table->integer('sent_count')->default(0);
            $table->string('status', 20)->default('draft'); // draft, sent, scheduled
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_campaigns');
        Schema::dropIfExists('barber_leaves');

        Schema::table('hairstyles', function (Blueprint $table) {
            $table->dropForeign(['recommended_combo_id']);
            $table->dropColumn('recommended_combo_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['hair_notes', 'result_photos']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['is_combo', 'original_price', 'combo_items']);
        });
    }
};

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
     
 Schema::create('emp_permissions', function (Blueprint $table) {
    $table->id();

    // الموظف
    $table->foreignId('emp_data_id')
        ->constrained('emp_datas')
        ->cascadeOnDelete();

    // السنة
    $table->foreignId('year_id')
        ->constrained('years')
        ->cascadeOnDelete();

    // الشهر
    $table->foreignId('month_id')
        ->constrained('months')
        ->cascadeOnDelete();

    // تاريخ الإذن
    $table->date('permission_date');

    // وقت الإذن (من - إلى) مع التاريخ
    $table->dateTime('from_datetime');
    $table->dateTime('to_datetime');

    // نوع الإذن
    // 1 = خروج | 2 = غياب | 3 = انصراف
    $table->tinyInteger('permission_type');

    // حالة الخصم
    // 0 = بدون خصم | 1 = بخصم
    $table->boolean('with_deduction')
        ->default(false);

    // ملاحظات (اختياري)
    $table->text('notes')->nullable();

    // أنشئ بواسطة
    $table->string('created_by')->nullable();

    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_permissions');
    }
};

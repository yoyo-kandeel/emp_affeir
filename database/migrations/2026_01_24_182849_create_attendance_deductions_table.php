<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('attendance_deductions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('emp_data_id')->constrained('emp_datas')->onDelete('cascade');
    $table->date('date'); // اليوم الذي تم الخصم فيه
    $table->decimal('lateness_deduction', 8, 2)->default(0); // خصم التأخير
    $table->decimal('early_leave_deduction', 8, 2)->default(0); // خصم الانصراف المبكر
    $table->decimal('total_deduction', 8, 2)->default(0); // إجمالي الخصم
    $table->timestamps();
    $table->softDeletes();

    $table->unique(['emp_data_id','date']); // يوم واحد لكل موظف
});


    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_deductions');
    }
};

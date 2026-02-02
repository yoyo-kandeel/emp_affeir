<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_shift', function (Blueprint $table) {
            $table->id();

            // ربط الموظف
            $table->foreignId('emp_data_id')
                  ->constrained('emp_datas')
                  ->onDelete('cascade');

            // ربط الورديه
            $table->foreignId('shift_id')
                  ->constrained('shifts')
                  ->onDelete('cascade');

            // فترة الورديه
            $table->date('from_date'); // بداية فترة الوردية
            $table->date('to_date');   // نهاية فترة الوردية

            // الأيام التي يعمل فيها الموظف خلال الأسبوع
            // يمكن تخزينها كنص مفصول بفواصل: "Monday,Tuesday,Friday"
            // أو كـ JSON: ["Monday","Tuesday"]
            $table->json('work_days')->nullable();
    $table->softDeletes();

            $table->timestamps();

            // منع تكرار نفس الورديه لنفس الموظف في نفس الفترة
            $table->unique(['emp_data_id', 'shift_id', 'from_date', 'to_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_shift');
    }
};

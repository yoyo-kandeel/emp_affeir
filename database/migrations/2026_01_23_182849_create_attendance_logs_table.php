<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
   Schema::create('attendance_logs', function (Blueprint $table) {
    $table->id();
    
    // ربط بسجل الموظف
    $table->foreignId('emp_data_id')
          ->constrained('emp_datas')
          ->onDelete('cascade');
    
    // ربط بجهاز البصمة
    $table->foreignId('fingerprint_device_id')
          ->constrained('fingerprint_devices')
          ->onDelete('cascade');
    
    $table->integer('print_id'); // رقم الطباعة/البصمة
    $table->date('log_date');    // تاريخ الدخول/الخروج
    $table->time('log_time');    // الوقت الفعلي
    $table->enum('type', ['in','out']); // نوع السجل: دخول/خروج
    $table->timestamps();
        $table->softDeletes();


    // لتجنب تكرار نفس السجل من الجهاز لنفس الموظف
$table->unique(['emp_data_id','fingerprint_device_id','print_id'], 'attendance_unique_idx');
});


    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};

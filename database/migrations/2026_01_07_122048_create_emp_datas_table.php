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
  Schema::create('emp_datas', function (Blueprint $table) {
    $table->id();
    $table->string('full_name');                       // الاسم الكامل
    $table->unsignedBigInteger('emp_number');                     // رقم الموظف
    $table->date('birth_date')->nullable();            // تاريخ الميلاد
    $table->string('birth_place')->nullable();           // مكان الميلاد
    $table->string('gender')->nullable();              // النوع
    $table->string('nationality')->nullable();         // الجنسية
    $table->string('marital_status')->nullable();      // الحالة الاجتماعية
    $table->integer('children_count')->default(0); // عدد الأطفال
    $table->string('national_id')->unique()->nullable(); // الرقم القومي
    $table->string('phone')->nullable();               // رقم الهاتف
    $table->text('address')->nullable();               // العنوان
    $table->string('status_service')->nullable();      // الموقف من التجنيد
    $table->string('experience')->nullable();          // الخبرات السابقة
    $table->string('certificate')->nullable();         // الشهادة 
    $table->date('hire_date')->nullable();              // تاريخ التعيين
    $table->unsignedBigInteger('department_id')->nullable(); // القسم
    $table->unsignedBigInteger('job_id')->nullable(); // الوظيفة
    $table->string('status')->default('غير نشط');              // الحالة (نشط/غير نشط )
    $table->text('notes')->nullable();                 // ملاحظات
    $table->string('profile_image')->nullable();         // صورة الشخصية
    $table->string('created_by')->nullable();          // تم الإنشاء بواسطة
    $table->integer('print_id');                        // كود البصمة
    $table->string('english_name')->nullable();          // الاسم بالإنجليزي
    $table->string('computer_skills')->nullable();       // ايجادة الكمبيوتر
    $table->string('english_proficiency')->nullable();    // مستوى اجادة اللغة الانجليزية
    $table->string  ('religion')->nullable();          // الديانة  
    $table->softDeletes();
    $table->timestamps();

    // العلاقات
    $table->foreign('department_id')
        ->references('id')
        ->on('departments')
        ->nullOnDelete();
    $table->foreign('job_id')
        ->references('id')
        ->on('jobs')
        ->nullOnDelete();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_datas');
    }
};

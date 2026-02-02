<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id(); // رقم المنشأة تلقائي
            $table->string('name'); // اسم المنشأة
            $table->string('english_name')->nullable(); // الاسم بالإنجليزي
            $table->string('tax_number')->nullable(); // رقم التسجيل الضريبي
            $table->string('commercial_register')->nullable(); // السجل التجاري
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('email')->nullable(); // البريد الإلكتروني
            $table->string('website')->nullable(); // موقع إلكتروني
            $table->string('address')->nullable(); // العنوان
            $table->text('description')->nullable(); // وصف المنشأة
            $table->string('logo')->nullable(); // مسار أو اسم ملف اللوجو
            $table->string('created_by')->nullable(); // مستخدم أنشأ السجل
            $table->timestamps(); // created_at و updated_at
            $table->softDeletes(); // حذف ناعم
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};

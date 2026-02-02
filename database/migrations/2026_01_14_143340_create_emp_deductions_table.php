<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('emp_deductions', function (Blueprint $table) {
            $table->id();

            // الموظف
            $table->unsignedBigInteger('emp_data_id');

            // السنة
            $table->unsignedBigInteger('year_id');

            // الشهر
            $table->unsignedBigInteger('month_id');

            // نوع الخصم
            $table->string('deduction_type');

            // قيمة / عدد الخصم
            $table->decimal('quantity', 8, 2);

            // المستخدم اللي أنشأ الخصم
            $table->string('created_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // العلاقات (Foreign Keys)
            $table->foreign('emp_data_id')
                  ->references('id')
                  ->on('emp_datas')
                  ->onDelete('cascade');

            $table->foreign('year_id')
                  ->references('id')
                  ->on('years')
                  ->onDelete('cascade');

            $table->foreign('month_id')
                  ->references('id')
                  ->on('months')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emp_deductions');
    }
};

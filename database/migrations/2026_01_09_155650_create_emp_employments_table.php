<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employment_data', function (Blueprint $table) {
            $table->id();
$table->unsignedBigInteger('emp_id'); // تعريف العمود أولاً


            $table->decimal('basic_salary', 10, 2); // الراتب الأساسي

            $table->boolean('insured')->default(false); // مؤمن عليه أم لا

            $table->date('insurance_date')->nullable(); // تاريخ التأمين

            $table->decimal('insurance_rate', 5, 2)->nullable(); // نسبة التأمين %

            $table->decimal('insurance_amount', 10, 2)->nullable(); // مبلغ التأمين

            $table->string('insurance_number')->nullable();// رقم التأمين

            $table->string('created_by')->nullable();

            $table->softDeletes();

            $table->timestamps();



$table->foreign('emp_id')       
      ->references('id')
      ->on('emp_datas')
      ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employment_data');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emp_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->constrained('emp_datas')->onDelete('cascade');
            $table->foreignId('year_id')->constrained('years')->onDelete('cascade');
            $table->foreignId('month_id')->constrained('months')->onDelete('cascade');
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->integer('working_days')->default(30);
            $table->decimal('daily_rate', 10, 2)->default(0);
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->decimal('advance', 10, 2)->default(0);
            $table->tinyInteger('insurance_status')->default(0);
            $table->decimal('insurance_amount', 10, 2)->default(0);
            $table->integer('absence_days')->default(0);
            $table->decimal('delay_hours', 10, 2)->default(0);
            $table->decimal('penalties', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('total_allowances', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->string('payment_number')->nullable();
            $table->timestamps();
                $table->softDeletes();

        });

        Schema::create('salary_allowances', function(Blueprint $table){
            $table->id();
            $table->foreignId('emp_salary_id')->constrained('emp_salaries')->onDelete('cascade');
            $table->foreignId('allowance_id')->constrained('emp_allowances')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_allowances');
        Schema::dropIfExists('emp_salaries');
    }
};

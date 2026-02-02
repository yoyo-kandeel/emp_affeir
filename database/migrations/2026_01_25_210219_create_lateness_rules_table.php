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
Schema::create('lateness_rules', function (Blueprint $table) {
    $table->id();
    $table->integer('from_minutes'); // التأخير من
    $table->integer('to_minutes');   // التأخير إلى
    $table->enum('deduction_type', ['fixed', 'percentage', 'day']); // نوع الخصم للتأخير
    $table->decimal('deduction_value', 8, 2); // قيمة الخصم للتأخير
    $table->enum('early_leave_type', ['fixed','percentage','day'])->nullable(); // نوع الخصم للانصراف المبكر
    $table->decimal('early_leave_value', 8, 2)->nullable(); // قيمة الخصم للانصراف المبكر
    $table->string('notes')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
        $table->softDeletes();

});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lateness_rules');
    }
};

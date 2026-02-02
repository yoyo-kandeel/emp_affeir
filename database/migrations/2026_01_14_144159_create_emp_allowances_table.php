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
      Schema::create('emp_allowances', function (Blueprint $table) {
    $table->id();
$table->string('allowance_name');
$table->string('description')->nullable();

 
  $table->foreignId('year_id')
          ->constrained('years')
          ->cascadeOnDelete();

    $table->foreignId('month_id')
          ->constrained('months')
          ->cascadeOnDelete();


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
        Schema::dropIfExists('emp_allowances');
    }
};

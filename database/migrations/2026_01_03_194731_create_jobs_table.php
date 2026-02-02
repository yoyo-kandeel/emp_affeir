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
      Schema::create('jobs', function (Blueprint $table) {
    $table->id(); 

    $table->string('job_name');
    $table->string('description')->nullable();

    $table->unsignedBigInteger('department_id'); 
    $table->string('created_by')->nullable();

    $table->softDeletes();
    $table->timestamps();

    // Foreign Key
    $table->foreign('department_id')
          ->references('id')
          ->on('departments')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

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
        Schema::create('emp_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_data_id');
            $table->foreign('emp_data_id')->references('id')->on('emp_datas')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('created_by');
            $table->string('file_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_attachments');
    }
};

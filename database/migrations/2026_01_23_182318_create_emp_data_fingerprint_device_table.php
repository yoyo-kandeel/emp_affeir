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
      Schema::create('emp_data_fingerprint_device', function (Blueprint $table) {
    $table->id();
    $table->foreignId('emp_data_id')->constrained('emp_datas');
    $table->foreignId('fingerprint_device_id')->constrained('fingerprint_devices');
    $table->timestamps();
        $table->softDeletes();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_data_fingerprint_device');
    }
};

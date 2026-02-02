<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // اسم الوردية
    $table->time('start_time'); // وقت البداية
    $table->time('end_time'); // وقت النهاية
    $table->string('description')->nullable(); // ملاحظات
    $table->timestamps();
        $table->softDeletes();

});

    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};


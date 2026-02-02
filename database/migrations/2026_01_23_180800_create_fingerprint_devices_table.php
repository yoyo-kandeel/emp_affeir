<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
    Schema::create('fingerprint_devices', function (Blueprint $table) {
    $table->id();
    $table->string('ip_address');
    $table->integer('port')->default(4370);
    $table->string('type');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
        $table->softDeletes();

});

    }

    public function down()
    {
        Schema::dropIfExists('fingerprint_devices');
    }
};

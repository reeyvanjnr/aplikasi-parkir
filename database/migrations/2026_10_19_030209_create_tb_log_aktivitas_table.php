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
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->nullable()->constrained('tb_user', 'id_user')->nullOnDelete();
            $table->string('aktivitas', 100);
            $table->text('deskripsi')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
    }
};

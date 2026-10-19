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
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->foreignId('id_kendaraan')->constrained('tb_kendaraan', 'id_kendaraan');
            $table->foreignId('id_user')->constrained('tb_user', 'id_user');
            $table->foreignId('id_tarif')->constrained('tb_tarif', 'id_tarif');
            $table->foreignId('id_area')->constrained('tb_area_parkir', 'id_area');
            $table->timestamp('waktu_masuk');
            $table->timestamp('waktu_keluar')->nullable();
            $table->unsignedInteger('biaya')->default(0);
            $table->string('status', 30)->default('parkir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi');
    }
};

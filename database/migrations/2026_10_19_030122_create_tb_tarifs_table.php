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
        Schema::create('tb_tarif', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->string('jenis_kendaraan', 30)->unique();
            $table->unsignedInteger('tarif_per_jam');
            $table->unsignedInteger('tarif_maksimal')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tarif');
    }
};

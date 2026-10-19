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
        Schema::create('tb_area_parkir', function (Blueprint $table) {
            $table->id('id_area');
            $table->string('nama_area')->unique();
            $table->string('jenis_kendaraan', 30);
            $table->unsignedInteger('kapasitas')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_area_parkir');
    }
};

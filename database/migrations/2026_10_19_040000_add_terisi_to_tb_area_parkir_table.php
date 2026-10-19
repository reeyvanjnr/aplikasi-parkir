<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_area_parkir', function (Blueprint $table) {
            $table->unsignedInteger('terisi')->default(0)->after('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::table('tb_area_parkir', function (Blueprint $table) {
            $table->dropColumn('terisi');
        });
    }
};

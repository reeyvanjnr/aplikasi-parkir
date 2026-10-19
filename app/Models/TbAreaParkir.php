<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbAreaParkir extends Model
{
    protected $table = 'tb_area_parkir';

    protected $primaryKey = 'id_area';

    protected $fillable = [
        'nama_area',
        'jenis_kendaraan',
        'kapasitas',
        'terisi',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas' => 'integer',
            'terisi' => 'integer',
            'status_aktif' => 'boolean',
        ];
    }
}

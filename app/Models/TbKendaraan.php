<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbKendaraan extends Model
{
    protected $table = 'tb_kendaraan';

    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'nomor_polisi',
        'jenis_kendaraan',
        'merk',
        'warna',
    ];
}

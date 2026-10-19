<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TbTransaksi extends Model
{
    protected $table = 'tb_transaksi';

    protected $primaryKey = 'id_parkir';

    protected $fillable = [
        'id_kendaraan',
        'id_user',
        'id_tarif',
        'id_area',
        'waktu_masuk',
        'waktu_keluar',
        'biaya',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'waktu_masuk' => 'datetime',
            'waktu_keluar' => 'datetime',
            'biaya' => 'integer',
        ];
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(TbKendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(TbUser::class, 'id_user', 'id_user');
    }

    public function tarif(): BelongsTo
    {
        return $this->belongsTo(TbTarif::class, 'id_tarif', 'id_tarif');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(TbAreaParkir::class, 'id_area', 'id_area');
    }
}

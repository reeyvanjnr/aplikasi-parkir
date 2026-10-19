<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TbLogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'aktivitas',
        'deskripsi',
        'ip_address',
        'user_agent',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TbUser::class, 'id_user', 'id_user');
    }
}

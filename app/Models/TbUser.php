<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TbUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_user',
        'username',
        'email',
        'password',
        'role',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status_aktif' => 'boolean',
            'email_verified_at' => 'datetime',
        ];
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(TbLogAktivitas::class, 'id_user', 'id_user');
    }
}

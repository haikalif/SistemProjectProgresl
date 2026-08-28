<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBagian extends Model
{
    protected $table = 'bagian';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function aktivitas() {
        return $this->hasMany(ModelAktivitas::class, 'bagian_id', 'id');
    }

    public function usersProfiles() {
        return $this->hasMany(ModelUsersProfile::class, 'bagian_id', 'id');
    }

    public function keterangan() {
        return $this->hasMany(ModelKeterangan::class, 'bagian_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelUsersProfile extends Model
{
    use SoftDeletes;

    protected $table = 'users_profile';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'nama_lengkap', 'nrp', 'alamat', 'foto', 'bagian_id', 'level_id', 'status_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bagian() {
        return $this->belongsTo(ModelBagian::class, 'bagian_id');
    }

    public function level() {
        return $this->belongsTo(ModelLevels::class, 'level_id');
    }

    public function status() {
        return $this->belongsTo(ModelStatuses::class, 'status_id');
    }

    public function proyekUsers() {
        return $this->hasMany(ModelProyekUser::class, 'users_profile_id');
    }

    public function jamKerja() {
        return $this->hasMany(ModelJamKerja::class, 'users_profile_id');
    }

    public function jamPerTanggal() {
        return $this->hasMany(ModelJamPerTanggal::class, 'users_profile_id');
    }

    public function lembur() {
        return $this->hasMany(ModelLembur::class, 'users_profile_id');
    }

}

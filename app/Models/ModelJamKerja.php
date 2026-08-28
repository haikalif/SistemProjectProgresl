<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelJamKerja extends Model
{
    use SoftDeletes;

    protected $table = 'jam_kerja';
    protected $primaryKey = 'id';

    protected $fillable = ['users_profile_id', 'no_wbs', 'kode_proyek', 'proyek_id', 'aktivitas_id', 'tanggal', 'jumlah_jam', 'keterangan', 'status_id', 'mode_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usersProfile() {
        return $this->belongsTo(ModelUsersProfile::class, 'users_profile_id');
    }

    public function proyek() {
        return $this->belongsTo(ModelProyek::class, 'proyek_id');
    }

    public function aktivitas() {
        return $this->belongsTo(ModelAktivitas::class, 'aktivitas_id');
    }

    public function status() {
        return $this->belongsTo(ModelStatusJamKerja::class, 'status_id');
    }

    public function mode() {
        return $this->belongsTo(ModelModeJamKerja::class, 'mode_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelProyek extends Model
{
    use SoftDeletes;

    protected $table = 'proyek';
    protected $primaryKey = 'id';

    protected $fillable = ['kode', 'nama', 'tanggal', 'nama_sekolah'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
    ];

    public function proyekUsers() {
        return $this->hasMany(ModelProyekUser::class, 'proyek_id', 'id');
    }

    public function jamKerja() {
        return $this->hasMany(ModelJamKerja::class, 'proyek_id', 'id');
    }

    public function jamPerTanggal() {
        return $this->hasMany(ModelJamPerTanggal::class, 'proyek_id', 'id');
    }

    public function keterangan() {
        return $this->hasMany(ModelKeterangan::class, 'proyek_id', 'id');
    }

    public function lembur() {
        return $this->hasMany(ModelLembur::class, 'proyek_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelAktivitas extends Model
{
    use SoftDeletes;

    protected $table = 'aktivitas';
    protected $primaryKey = 'id';

    protected $fillable = ['bagian_id', 'no_wbs', 'nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
    ];

    public function bagian() {
        return $this->belongsTo(ModelBagian::class, 'bagian_id');
    }

    public function jamKerja() {
        return $this->hasMany(ModelJamKerja::class, 'aktivitas_id', 'id');
    }

}

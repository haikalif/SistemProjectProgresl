<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelModeJamKerja extends Model
{
    use SoftDeletes;

    protected $table = 'mode_jam_kerja';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function jamKerja()
    {
        return $this->hasMany(ModelJamKerja::class, 'mode_id');
    }
}

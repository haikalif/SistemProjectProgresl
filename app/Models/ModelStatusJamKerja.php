<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelStatusJamKerja extends Model
{
    use SoftDeletes;

    protected $table = 'status_jam_kerja';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function jamKerja() {
        return $this->hasMany(ModelJamKerja::class, 'status_id', 'id');
    }

}

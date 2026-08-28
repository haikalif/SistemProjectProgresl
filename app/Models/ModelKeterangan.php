<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelKeterangan extends Model
{
    use SoftDeletes;

    protected $table = 'keterangan';
    protected $primaryKey = 'id';

    protected $fillable = ['bagian_id', 'proyek_id', 'tanggal'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
    ];

    public function bagian() {
        return $this->belongsTo(ModelBagian::class, 'bagian_id');
    }

    public function proyek() {
        return $this->belongsTo(ModelProyek::class, 'proyek_id');
    }

}

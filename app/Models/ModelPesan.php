<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPesan extends Model
{
    use SoftDeletes;

    protected $table = 'pesan';
    protected $primaryKey = 'id';

    protected $fillable = ['pengirim', 'penerima', 'isi', 'parent_id', 'tgl_pesan', 'jenis_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function jenis() {
        return $this->belongsTo(ModelJenisPesan::class, 'jenis_id');
    }

    public function parent() {
        return $this->belongsTo(ModelPesan::class, 'parent_id');
    }

    public function replies() {
        return $this->hasMany(ModelPesan::class, 'parent_id', 'id');
    }

}

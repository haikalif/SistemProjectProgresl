<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelJenisPesan extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_pesan';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pesan() {
        return $this->hasMany(ModelPesan::class, 'jenis_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelLembur extends Model
{
    protected $table = 'lembur';
    protected $primaryKey = 'id';

    protected $fillable = ['users_profile_id', 'proyek_id', 'tanggal'];

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

}

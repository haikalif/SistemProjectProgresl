<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelJamPerTanggal extends Model
{
    use SoftDeletes;

    protected $table = 'jam_per_tanggal';
    protected $primaryKey = 'id';

    protected $fillable = ['users_profile_id', 'proyek_id', 'tanggal', 'jam'];

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

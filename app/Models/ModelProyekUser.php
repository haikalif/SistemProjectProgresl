<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelProyekUser extends Model
{
    use SoftDeletes;

    protected $table = 'proyek_user';
    protected $primaryKey = 'id';

    protected $fillable = ['proyek_id', 'users_profile_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
    ];

    public function proyek() {
        return $this->belongsTo(ModelProyek::class, 'proyek_id');
    }

    public function usersProfile() {
        return $this->belongsTo(ModelUsersProfile::class, 'users_profile_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelLevels extends Model
{
    use SoftDeletes;

    protected $table = 'levels';
    protected $primaryKey = 'id';

    protected $fillable = ['nama'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usersProfiles() {
        return $this->hasMany(ModelUsersProfile::class, 'level_id', 'id');
    }

}

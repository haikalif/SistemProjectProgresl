<?php

$models = [
    'ModelLevels' => [
        'table' => 'levels', 'fillable' => "['nama']", 'softDeletes' => true,
        'relations' => [
            "public function usersProfiles() { return \$this->hasMany(ModelUsersProfile::class, 'level_id', 'id'); }"
        ]
    ],
    'ModelStatuses' => [
        'table' => 'statuses', 'fillable' => "['nama']", 'softDeletes' => true,
        'relations' => [
            "public function usersProfiles() { return \$this->hasMany(ModelUsersProfile::class, 'status_id', 'id'); }"
        ]
    ],
    'ModelStatusJamKerja' => [
        'table' => 'status_jam_kerja', 'fillable' => "['nama']", 'softDeletes' => true,
        'relations' => [
            "public function jamKerja() { return \$this->hasMany(ModelJamKerja::class, 'status_id', 'id'); }"
        ]
    ],
    'ModelModeJamKerja' => [
        'table' => 'mode_jam_kerja', 'fillable' => "['nama']", 'softDeletes' => true,
        'relations' => [
            "public function jamKerja() { return \$this->hasMany(ModelJamKerja::class, 'mode_id', 'id'); }"
        ]
    ],
    'ModelJenisPesan' => [
        'table' => 'jenis_pesan', 'fillable' => "['nama']", 'softDeletes' => true,
        'relations' => [
            "public function pesan() { return \$this->hasMany(ModelPesan::class, 'jenis_id', 'id'); }"
        ]
    ],
    'ModelBagian' => [
        'table' => 'bagian', 'fillable' => "['nama']", 'softDeletes' => false,
        'relations' => [
            "public function aktivitas() { return \$this->hasMany(ModelAktivitas::class, 'bagian_id', 'id'); }",
            "public function usersProfiles() { return \$this->hasMany(ModelUsersProfile::class, 'bagian_id', 'id'); }",
            "public function keterangan() { return \$this->hasMany(ModelKeterangan::class, 'bagian_id', 'id'); }"
        ]
    ],
    'ModelAktivitas' => [
        'table' => 'aktivitas', 'fillable' => "['bagian_id', 'no_wbs', 'nama']", 'softDeletes' => true,
        'relations' => [
            "public function bagian() { return \$this->belongsTo(ModelBagian::class, 'bagian_id', 'id'); }",
            "public function jamKerja() { return \$this->hasMany(ModelJamKerja::class, 'aktivitas_id', 'id'); }"
        ]
    ],
    'ModelProyek' => [
        'table' => 'proyek', 'fillable' => "['kode', 'nama', 'tanggal', 'nama_sekolah']", 'softDeletes' => true,
        'relations' => [
            "public function proyekUsers() { return \$this->hasMany(ModelProyekUser::class, 'proyek_id', 'id'); }",
            "public function jamKerja() { return \$this->hasMany(ModelJamKerja::class, 'proyek_id', 'id'); }",
            "public function jamPerTanggal() { return \$this->hasMany(ModelJamPerTanggal::class, 'proyek_id', 'id'); }",
            "public function keterangan() { return \$this->hasMany(ModelKeterangan::class, 'proyek_id', 'id'); }",
            "public function lembur() { return \$this->hasMany(ModelLembur::class, 'proyek_id', 'id'); }"
        ]
    ],
    'ModelUsersProfile' => [
        'table' => 'users_profile', 'fillable' => "['user_id', 'nama_lengkap', 'nrp', 'alamat', 'foto', 'bagian_id', 'level_id', 'status_id']", 'softDeletes' => true,
        'relations' => [
            "public function user() { return \$this->belongsTo(User::class, 'user_id', 'id'); }",
            "public function bagian() { return \$this->belongsTo(ModelBagian::class, 'bagian_id', 'id'); }",
            "public function level() { return \$this->belongsTo(ModelLevels::class, 'level_id', 'id'); }",
            "public function status() { return \$this->belongsTo(ModelStatuses::class, 'status_id', 'id'); }",
            "public function proyekUsers() { return \$this->hasMany(ModelProyekUser::class, 'users_profile_id', 'id'); }",
            "public function jamKerja() { return \$this->hasMany(ModelJamKerja::class, 'users_profile_id', 'id'); }",
            "public function jamPerTanggal() { return \$this->hasMany(ModelJamPerTanggal::class, 'users_profile_id', 'id'); }",
            "public function lembur() { return \$this->hasMany(ModelLembur::class, 'users_profile_id', 'id'); }"
        ]
    ],
    'ModelProyekUser' => [
        'table' => 'proyek_user', 'fillable' => "['proyek_id', 'users_profile_id']", 'softDeletes' => true,
        'relations' => [
            "public function proyek() { return \$this->belongsTo(ModelProyek::class, 'proyek_id', 'id'); }",
            "public function usersProfile() { return \$this->belongsTo(ModelUsersProfile::class, 'users_profile_id', 'id'); }"
        ]
    ],
    'ModelJamKerja' => [
        'table' => 'jam_kerja', 'fillable' => "['users_profile_id', 'no_wbs', 'kode_proyek', 'proyek_id', 'aktivitas_id', 'tanggal', 'jumlah_jam', 'keterangan', 'status_id', 'mode_id']", 'softDeletes' => true,
        'relations' => [
            "public function usersProfile() { return \$this->belongsTo(ModelUsersProfile::class, 'users_profile_id', 'id'); }",
            "public function proyek() { return \$this->belongsTo(ModelProyek::class, 'proyek_id', 'id'); }",
            "public function aktivitas() { return \$this->belongsTo(ModelAktivitas::class, 'aktivitas_id', 'id'); }",
            "public function status() { return \$this->belongsTo(ModelStatusJamKerja::class, 'status_id', 'id'); }",
            "public function mode() { return \$this->belongsTo(ModelModeJamKerja::class, 'mode_id', 'id'); }"
        ]
    ],
    'ModelJamPerTanggal' => [
        'table' => 'jam_per_tanggal', 'fillable' => "['users_profile_id', 'proyek_id', 'tanggal', 'jam']", 'softDeletes' => true,
        'relations' => [
            "public function usersProfile() { return \$this->belongsTo(ModelUsersProfile::class, 'users_profile_id', 'id'); }",
            "public function proyek() { return \$this->belongsTo(ModelProyek::class, 'proyek_id', 'id'); }"
        ]
    ],
    'ModelKeterangan' => [
        'table' => 'keterangan', 'fillable' => "['bagian_id', 'proyek_id', 'tanggal']", 'softDeletes' => true,
        'relations' => [
            "public function bagian() { return \$this->belongsTo(ModelBagian::class, 'bagian_id', 'id'); }",
            "public function proyek() { return \$this->belongsTo(ModelProyek::class, 'proyek_id', 'id'); }"
        ]
    ],
    'ModelLembur' => [
        'table' => 'lembur', 'fillable' => "['users_profile_id', 'proyek_id', 'tanggal']", 'softDeletes' => false,
        'relations' => [
            "public function usersProfile() { return \$this->belongsTo(ModelUsersProfile::class, 'users_profile_id', 'id'); }",
            "public function proyek() { return \$this->belongsTo(ModelProyek::class, 'proyek_id', 'id'); }"
        ]
    ],
    'ModelPesan' => [
        'table' => 'pesan', 'fillable' => "['pengirim', 'penerima', 'isi', 'parent_id', 'tgl_pesan', 'jenis_id']", 'softDeletes' => true,
        'relations' => [
            "public function jenis() { return \$this->belongsTo(ModelJenisPesan::class, 'jenis_id', 'id'); }",
            "public function parent() { return \$this->belongsTo(ModelPesan::class, 'parent_id', 'id'); }",
            "public function replies() { return \$this->hasMany(ModelPesan::class, 'parent_id', 'id'); }"
        ]
    ],
];

foreach ($models as $className => $data) {
    $softDeletesImport = $data['softDeletes'] ? "\nuse Illuminate\Database\Eloquent\SoftDeletes;" : "";
    $softDeletesTrait = $data['softDeletes'] ? "\n    use SoftDeletes;\n" : "";

    // Join relations with indents
    $relationsStr = "";
    if (!empty($data['relations'])) {
        foreach ($data['relations'] as $rel) {
            // Add basic formatting to make it readable
            $formattedRel = str_replace("{ return", "{\n        return", $rel);
            $formattedRel = str_replace("; }", ";\n    }\n", $formattedRel);
            $relationsStr .= "\n    " . $formattedRel;
        }
    }

    $content = <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;$softDeletesImport

class {$className} extends Model
{{$softDeletesTrait}
    protected \$table = '{$data['table']}';
    protected \$primaryKey = 'id';

    protected \$fillable = {$data['fillable']};

    protected \$casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
$relationsStr
}

PHP;

    file_put_contents("/mnt/c/laragon/www/SistemProjectProgresl/app/Models/{$className}.php", $content);
    echo "Updated {$className}.php\n";
}


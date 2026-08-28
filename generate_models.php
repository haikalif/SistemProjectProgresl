<?php

$models = [
    'ModelLevels' => ['table' => 'levels', 'fillable' => "['nama']", 'softDeletes' => true],
    'ModelStatuses' => ['table' => 'statuses', 'fillable' => "['nama']", 'softDeletes' => true],
    'ModelStatusJamKerja' => ['table' => 'status_jam_kerja', 'fillable' => "['nama']", 'softDeletes' => true],
    'ModelModeJamKerja' => ['table' => 'mode_jam_kerja', 'fillable' => "['nama']", 'softDeletes' => true],
    'ModelJenisPesan' => ['table' => 'jenis_pesan', 'fillable' => "['nama']", 'softDeletes' => true],
    'ModelAktivitas' => ['table' => 'aktivitas', 'fillable' => "['bagian_id', 'no_wbs', 'nama']", 'softDeletes' => true],
    'ModelProyek' => ['table' => 'proyek', 'fillable' => "['kode', 'nama', 'tanggal', 'nama_sekolah']", 'softDeletes' => true],
    'ModelUsersProfile' => ['table' => 'users_profile', 'fillable' => "['user_id', 'nama_lengkap', 'nrp', 'alamat', 'foto', 'bagian_id', 'level_id', 'status_id']", 'softDeletes' => true],
    'ModelProyekUser' => ['table' => 'proyek_user', 'fillable' => "['proyek_id', 'users_profile_id']", 'softDeletes' => true],
    'ModelJamKerja' => ['table' => 'jam_kerja', 'fillable' => "['users_profile_id', 'no_wbs', 'kode_proyek', 'proyek_id', 'aktivitas_id', 'tanggal', 'jumlah_jam', 'keterangan', 'status_id', 'mode_id']", 'softDeletes' => true],
    'ModelJamPerTanggal' => ['table' => 'jam_per_tanggal', 'fillable' => "['users_profile_id', 'proyek_id', 'tanggal', 'jam']", 'softDeletes' => true],
    'ModelKeterangan' => ['table' => 'keterangan', 'fillable' => "['bagian_id', 'proyek_id', 'tanggal']", 'softDeletes' => true],
    'ModelLembur' => ['table' => 'lembur', 'fillable' => "['users_profile_id', 'proyek_id', 'tanggal']", 'softDeletes' => false],
    'ModelPesan' => ['table' => 'pesan', 'fillable' => "['pengirim', 'penerima', 'isi', 'parent_id', 'tgl_pesan', 'jenis_id']", 'softDeletes' => true],
];

foreach ($models as $className => $data) {
    $softDeletesImport = $data['softDeletes'] ? "\nuse Illuminate\Database\Eloquent\SoftDeletes;" : "";
    $softDeletesTrait = $data['softDeletes'] ? "\n    use SoftDeletes;\n" : "";

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
}

PHP;

    file_put_contents("/mnt/c/laragon/www/SistemProjectProgresl/app/Models/{$className}.php", $content);
    echo "Generated {$className}.php\n";
}


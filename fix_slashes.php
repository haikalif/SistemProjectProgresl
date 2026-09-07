<?php

$dirs = ['User', 'JamKerja', 'JamPerTanggal', 'Lembur', 'Pesan', 'Keterangan', 'ProyekUser'];
foreach ($dirs as $dir) {
    $file = __DIR__ . "/graphql/{$dir}/schema.graphql";
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Replace single backslashes in model strings with double backslashes
        $content = preg_replace('/"App\\\\Models\\\\([A-Za-z0-9_]+)"/', '"App\\\\\\\\Models\\\\\\\\$1"', $content);
        file_put_contents($file, $content);
        echo "Fixed {$file}\n";
    }
}

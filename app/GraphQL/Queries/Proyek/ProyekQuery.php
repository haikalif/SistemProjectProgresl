<?php

namespace App\GraphQL\Queries\Proyek;

use App\Models\ModelProyek;

class ProyekQuery
{

    public function getProyek($_, array $args)
    {
        $query = ModelProyek::query();

        if (!empty($args['search'])) {
            $query->where('nama_proyek', 'like', '%' . $args['search'] . '%')
                ->orWhere('id', 'like', '%' . $args['search'] . '%')
                ->orWhere('nama', 'like', '%' . $args['search'] . '%')
                ->orWhere('kode', 'like', '%' . $args['search'] . '%')
                ->orWhere('nama_sekolah', 'like', '%' . $args['search'] . '%');
        }

        return $query->get();
    }
}

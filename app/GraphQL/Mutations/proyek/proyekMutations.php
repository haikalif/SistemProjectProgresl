<?php

namespace App\GraphQL\Mutations\proyek;

use App\Models\ModelProyek;

class ProyekMutations
{

    public function restore($_, array $args)
    {
        $proyek = ModelProyek::withTrashed()->find($args['id']);
        if ($proyek) {
            $proyek->restore();
            return $proyek;
        }
    }

    public function forceDelete($_, array $args)
    {
        $proyek = ModelProyek::withTrashed()->find($args['id']);
        if ($proyek) {
            $proyek->forceDelete();
            return $proyek;
        }
    }
}

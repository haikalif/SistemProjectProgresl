<?php

namespace App\GraphQL\Mutations\StatusJamKerja;

use App\Models\ModelStatusJamKerja;

class StatusJamKerjaMutations
{
    public function restore($_, array $args)
    {
        $statusJamKerja = ModelStatusJamKerja::withTrashed()->find($args['id']);
        if ($statusJamKerja) {
            $statusJamKerja->restore();
            return $statusJamKerja;
        }
    }

    public function forceDelete($_, array $args)
    {
        $statusJamKerja = ModelStatusJamKerja::withTrashed()->find($args['id']);
        if ($statusJamKerja) {
            $statusJamKerja->forceDelete();
            return $statusJamKerja;
        }
    }
}

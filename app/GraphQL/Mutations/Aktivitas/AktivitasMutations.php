<?php

namespace App\GraphQL\Mutations\Aktivitas;

use App\Models\ModelAktivitas;

class AktivitasMutations
{
    public function restore($_, array $args)
    {
        $aktivitas = ModelAktivitas::withTrashed()->find($args['id']);
        if ($aktivitas) {
            $aktivitas->restore();
            return $aktivitas;
        }
    }

    public function forceDelete($_, array $args)
    {
        $aktivitas = ModelAktivitas::withTrashed()->find($args['id']);
        if ($aktivitas) {
            $aktivitas->forceDelete();
            return $aktivitas;
        }
    }
}

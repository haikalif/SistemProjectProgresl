<?php

namespace App\GraphQL\Mutations\ModeJamKerja;

use App\Models\ModelModeJamKerja;

class ModeJamKerjaMutations
{

    public function restore($_, array $args)
    {

        $modeJamKerja = ModelModeJamKerja::withTrashed()->find($args['id']);
        if ($modeJamKerja) {
            $modeJamKerja->restore();
            return $modeJamKerja;
        }
    }

    public function forceDelete($_, array $args)
    {
        $modeJamKerja = ModelModeJamKerja::withTrashed()->find($args['id']);
        if ($modeJamKerja) {
            $modeJamKerja->forceDelete();
            return $modeJamKerja;
        }
    }
}

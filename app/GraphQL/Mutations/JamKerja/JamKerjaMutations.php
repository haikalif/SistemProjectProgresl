<?php

namespace App\GraphQL\Mutations\JamKerja;

use App\Models\ModelJamKerja;

class JamKerjaMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelJamKerja') === 'User'
            ? ModelJamKerja::withTrashed()->find($args['id'])
            : ModelJamKerja::withTrashed()->find($args['id']);

        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = ModelJamKerja::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}

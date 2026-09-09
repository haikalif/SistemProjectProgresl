<?php

namespace App\GraphQL\Mutations\JamPerTanggal;

use App\Models\ModelJamPerTanggal;

class JamPerTanggalMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelJamPerTanggal') === 'User'
            ? ModelJamPerTanggal::withTrashed()->find($args['id'])
            : ModelJamPerTanggal::withTrashed()->find($args['id']);

        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = ModelJamPerTanggal::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}

<?php

namespace App\GraphQL\Mutations\Keterangan;

use App\Models\ModelKeterangan;

class KeteranganMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelKeterangan') === 'User'
            ? ModelKeterangan::withTrashed()->find($args['id'])
            : ModelKeterangan::withTrashed()->find($args['id']);

        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = ModelKeterangan::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}

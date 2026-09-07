<?php

namespace App\GraphQL\Mutations\Keterangan;

use App\Models\ModelKeterangan;

class KeteranganMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelKeterangan') === 'User' 
            ? App\Models\ModelKeterangan::withTrashed()->find($args['id']) 
            : App\Models\ModelKeterangan::withTrashed()->find($args['id']);
            
        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = App\Models\ModelKeterangan::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}
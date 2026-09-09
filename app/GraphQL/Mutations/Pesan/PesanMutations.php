<?php

namespace App\GraphQL\Mutations\Pesan;

use App\Models\ModelPesan;

class PesanMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelPesan') === 'User'
            ? ModelPesan::withTrashed()->find($args['id'])
            : ModelPesan::withTrashed()->find($args['id']);

        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = ModelPesan::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}

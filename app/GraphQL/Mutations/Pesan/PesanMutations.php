<?php

namespace App\GraphQL\Mutations\Pesan;

use App\Models\ModelPesan;

class PesanMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelPesan') === 'User' 
            ? App\Models\ModelPesan::withTrashed()->find($args['id']) 
            : App\Models\ModelPesan::withTrashed()->find($args['id']);
            
        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = App\Models\ModelPesan::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}
<?php

namespace App\GraphQL\Mutations\ProyekUser;

use App\Models\ModelProyekUser;

class ProyekUserMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelProyekUser') === 'User' 
            ? App\Models\ModelProyekUser::withTrashed()->find($args['id']) 
            : App\Models\ModelProyekUser::withTrashed()->find($args['id']);
            
        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = App\Models\ModelProyekUser::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}
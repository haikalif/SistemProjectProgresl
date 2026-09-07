<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;

class UserMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\User') === 'User' 
            ? App\Models\User::withTrashed()->find($args['id']) 
            : App\Models\User::withTrashed()->find($args['id']);
            
        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = App\Models\User::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}
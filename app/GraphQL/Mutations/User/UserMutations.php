<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;

class UserMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\User') === 'User'
            ? User::withTrashed()->find($args['id'])
            : User::withTrashed()->find($args['id']);

        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = User::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}

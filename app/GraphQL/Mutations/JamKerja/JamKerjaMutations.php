<?php

namespace App\GraphQL\Mutations\JamKerja;

use App\Models\ModelJamKerja;

class JamKerjaMutations
{
    public function restore($_, array $args)
    {
        $record = class_basename('App\Models\ModelJamKerja') === 'User' 
            ? App\Models\ModelJamKerja::withTrashed()->find($args['id']) 
            : App\Models\ModelJamKerja::withTrashed()->find($args['id']);
            
        if ($record) {
            $record->restore();
            return $record;
        }
    }

    public function forceDelete($_, array $args)
    {
        $record = App\Models\ModelJamKerja::withTrashed()->find($args['id']);
        if ($record) {
            $record->forceDelete();
            return $record;
        }
    }
}
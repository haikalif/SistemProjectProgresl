<?php

namespace App\GraphQL\Mutations\Level;

use App\Models\ModelLevels;

class levelMutations
{

    public function restore($_, array $args)
    {

        $level = ModelLevels::withTrashed()->find($args['id']);
        $level->restore();
        return $level;
    }

    public function forceDelete($_, array $args)
    {

        $level = ModelLevels::withTrashed()->find($args['id']);
        $level->forceDelete();
        return $level;
    }
}

<?php

namespace App\GraphQL\Queries\level;

use App\Models\ModelLevels;

class LevelQuery
{

    public function showTrashed()
    {

        $leveltrashed = ModelLevels::onlyTrashed()->get();
        return $leveltrashed;
    }
}

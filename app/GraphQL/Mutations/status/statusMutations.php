<?php

namespace App\GraphQL\Mutations\Status;

use App\Models\ModelStatuses;


class StatusMutations{

public function restore($_, array $args)
    {
        $status = ModelStatuses::withTrashed()->find($args['id']);
        if ($status) {
            $status->restore();
            return $status;
        }
        return null;
    }

    public function forceDelete($_, array $args)
    {
        $status = ModelStatuses::withTrashed()->find($args['id']);
        if ($status) {
            $status->forceDelete();
            return $status;
        }
        return null;
    }
}

<?php

namespace App\GraphQL\Mutations\Status;


class StatusMutations{

public function restore($_, array $args)
    {
        $status = \App\Models\ModelStatuses::withTrashed()->find($args['id']);
        if ($status) {
            $status->restore();
            return $status;
        }
        return null;
    }

    public function forceDelete($_, array $args)
    {
        $status = \App\Models\ModelStatuses::withTrashed()->find($args['id']);
        if ($status) {
            $status->forceDelete();
            return $status;
        }
        return null;
    }
}

<?php

namespace App\GraphQL\Queries\level;

use App\Models\ModelLevels;

class LevelQuery
{
    public function all($_, array $args)
    {
        $query = ModelLevels::query();

        if (!empty($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $perPage = $args['first'] ?? 10;
        $page = $args['page'] ?? 1;

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'data'  => $paginator->items(),
            'PaginatorInfo' => [
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }

    public function showTrashed()
    {

        $leveltrashed = ModelLevels::onlyTrashed()->get();
        return $leveltrashed;
    }
}

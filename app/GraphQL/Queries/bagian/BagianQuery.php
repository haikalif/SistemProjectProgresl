<?php

namespace App\GraphQL\Queries\Bagian;

use App\Models\ModelBagian;

class BagianQuery
{

    public function all($_, array $args)
    {

        $query = ModelBagian::query();

        if (!empty($args['search'])) {
            $query->where('nama', 'like', '%' . $args['search'] . '%');
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
}

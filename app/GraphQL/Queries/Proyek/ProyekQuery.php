<?php

namespace App\GraphQL\Queries\Proyek;

use App\Models\ModelProyek;

class ProyekQuery
{

    public function all($_, array $args)
    {
        $query = ModelProyek::query();

        if (!empty($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kode', 'like', '%' . $search . '%')
                    ->orWhere('nama_sekolah', 'like', '%' . $search . '%')
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
        return ModelProyek::onlyTrashed()->get();
    }
}

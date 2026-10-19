<?php

namespace App\GraphQL\Queries\JamKerja;

use App\Models\ModelJamKerja;

class JamKerjaQuery
{
    public function all($_, array $args)
    {
        $query = ModelJamKerja::query();

        if (!empty($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('no_wbs', 'like', '%' . $search . '%')
                    ->orWhere('kode_proyek', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
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
        return ModelJamKerja::onlyTrashed()->get();
    }
}

<?php

namespace App\GraphQL\Queries\ProyekUser;

use App\Models\ModelProyekUser;

class ProyekUserQuery
{
    public function all($_, array $args)
    {
        $query = ModelProyekUser::query();

        if (!empty($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('proyek_id', 'like', '%' . $search . '%')
                    ->orWhere('users_profile_id', 'like', '%' . $search . '%');
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
        return ModelProyekUser::onlyTrashed()->get();
    }
}

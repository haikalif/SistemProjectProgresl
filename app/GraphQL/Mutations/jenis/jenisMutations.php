<?php

namespace App\GraphQL\Mutations\jenis;

use App\Models\ModelJenisPesan;

class JenisMutations
{

    public function restore($_, array $args)
    {
        $jenis = ModelJenisPesan::withTrashed()->find($args['id']);
        if ($jenis) {
            $jenis->restore();
            return $jenis;
        }
    }

    public function forceDelete($_, array $args)
    {
        $jenis = ModelJenisPesan::withTrashed()->find($args['id']);
        if ($jenis) {
            $jenis->forceDelete();
            return $jenis;
        }
    }
}

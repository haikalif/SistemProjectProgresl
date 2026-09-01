<?php

namespace App\GraphQL\Mutations\UsersProfile;

use App\Models\ModelUsersProfile;

class UsersProfileMutations
{

    public function restore($_, array $args)
    {

        $usersProfile = ModelUsersProfile::withTrashed()->find($args['id']);
        $usersProfile->restore();
        return $usersProfile;
    }

    public function forceDelete($_, array $args)
    {
        $usersProfile = ModelUsersProfile::withTrashed()->find($args['id']);
        $usersProfile->forceDelete();
        return $usersProfile;
    }
}

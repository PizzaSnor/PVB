<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Occasion;

class OccasionPolicy
{
    public function delete(User $user, Occasion $occasion)
    {
        return $user->isAdmin();
    }
}

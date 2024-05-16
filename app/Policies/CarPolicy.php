<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Car;

class CarPolicy
{
    public function delete(User $user, Car $car)
    {
        return $user->isAdmin();
    }
}

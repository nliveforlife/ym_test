<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserServiceProcessInterface
{
    public function process(User $user);
}

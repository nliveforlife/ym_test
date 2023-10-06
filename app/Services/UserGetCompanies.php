<?php

namespace App\Services;


use App\Models\User;
use App\Services\Interfaces\UserServiceProcessInterface;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserGetCompanies implements UserServiceProcessInterface
{
    use ProvidesConvenienceMethods;

    public function process(User $user): array
    {
        /**@var  \Illuminate\Database\Eloquent\Collection $data */
        $data = $user->companies()->getResults();

        return $data->toArray();
    }

}

<?php

namespace App\Repositories;


use App\Models\User;
use App\Services\RecoverPassword;
use App\Services\UserAddCompany;
use App\Services\UserAuth;
use App\Services\UserGetCompanies;
use App\Services\UserRegister;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserRepository
{

    use ProvidesConvenienceMethods;

    private User $user;

    public function setUser(User $user): UserRepository
    {
        $this->user = $user;

        return $this;
    }

    public function userAuth(Request $request)
    {
        $service = new UserAuth();

        return $service->process($request);
    }

    public function userRegister(Request $request)
    {
        $service = new UserRegister();

        return $service->process($request);
    }

    public function recoverPassword(Request $request)
    {
        $service = new RecoverPassword();

        return $service->process($request);
    }

    public function getCompanies(): array
    {
        $service = new UserGetCompanies();

        return $service->process($this->user);
    }

    public function addCompany(Request $request): bool
    {
        $service = new UserAddCompany();
        $service->setRequestData($request);

        return $service->process($this->user);
    }
}

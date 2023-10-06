<?php

namespace App\Services;


use App\Exceptions\UserAuthServiceException;
use App\Services\Interfaces\ServiceProcessInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserAuth implements ServiceProcessInterface
{
    use ProvidesConvenienceMethods;
    public function process(Request $request): array
    {
        try {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only(['email', 'password']);
        } catch (ValidationException $e) {

            throw new UserAuthServiceException($e->getMessage());
        }

        if (! $token = Auth::setTTL(7200)->attempt($credentials)) {

            throw new UserAuthServiceException('Login not found or password is wrong');
        }

        return [
            'bearer_token' => $token,
            'expires_in' => Auth::factory()->getTTL()
        ];
    }

}

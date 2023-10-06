<?php

namespace App\Services;


use App\Exceptions\UserRegisterServiceException;
use App\Models\User;
use App\Services\Interfaces\ServiceProcessInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserRegister implements ServiceProcessInterface
{

    use ProvidesConvenienceMethods;
    public function process(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);
        } catch (ValidationException $e){

            throw new UserRegisterServiceException($e->getMessage());
        }

        try {
            $data = new User();
            $data->first_name = $request->get('first_name');
            $data->last_name = $request->get('last_name');
            $data->phone = $request->get('phone');
            $data->email = $request->get('email');
            $data->password = app('hash')->make($request->get('password'));
            $data->save();

            return 'Successfully created!';
        } catch (\Exception $e) {

            throw new UserRegisterServiceException($e->getMessage());
        }
    }

}

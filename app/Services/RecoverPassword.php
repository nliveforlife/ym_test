<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserRecoveryPasswordServiceException;
use App\Models\User;
use App\Models\UsersRecoverPassword;
use App\Services\Interfaces\ServiceProcessInterface;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class RecoverPassword implements ServiceProcessInterface
{
    use ProvidesConvenienceMethods;

    private string $jwt_key;

    public function __construct(){
        $this->jwt_key = env('JWT_SECRET');
    }
    public function process(Request $request)
    {
        try {
            $this->validate($request, [
                'token' => 'required|string',
                'password' => 'required|confirmed',
            ]);
        } catch (ValidationException $e) {

            throw new UserRecoveryPasswordServiceException($e->getMessage());
        }

        $user = $this->getUser($request->get('token'));
        if (!$user instanceof User) {

            throw new UserRecoveryPasswordServiceException('User not found!');
        }

        try {
            $user->update(['password' => app('hash')->make($request->get('password'))]);

            return 'Successfully';
        } catch (\Exception $e) {

            throw new UserRecoveryPasswordServiceException($e->getMessage());
        }
    }

    private function getUser(string $token): ?User
    {
        /**@var  \Illuminate\Database\Eloquent\Collection $data */
        $data = UsersRecoverPassword::where('token', $token)
            ->take(1)
            ->get();

        if(($model = $data->first()) instanceof UsersRecoverPassword){
            /**@var UsersRecoverPassword $model */

            return User::where('id', $model->getAttribute('user_id_fk'))->take(1)->get()->first();
        }

        return null;
    }
}

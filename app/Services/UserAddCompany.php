<?php

namespace App\Services;


use App\Exceptions\UserAddCompanyServiceException;
use App\Models\Companies;
use App\Models\User;
use App\Services\Interfaces\UserServiceProcessInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class UserAddCompany implements UserServiceProcessInterface
{
    use ProvidesConvenienceMethods;

    private Request $request;

    public function setRequestData(Request $request){
        $this->request = $request;
    }

    public function process(User $user): bool
    {
        $model = new Companies();

        try {
            $this->validate($this->request, [
                'title' => 'required|string|unique:users_companies',
                'phone' => 'required|string',
                'description' => 'required|string'
            ]);
        } catch (ValidationException $e) {

            throw new UserAddCompanyServiceException($e->getMessage());
        }

        try {
            $model->title = $this->request->get('title');
            $model->phone = $this->request->get('phone');
            $model->description = $this->request->get('phone');
            $model->user_id_fk = $user->id;

            return $model->save();

        } catch (\Exception $e) {

            throw new UserAddCompanyServiceException('Failed!');
        }
    }
}

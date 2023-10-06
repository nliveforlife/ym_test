<?php

namespace App\Http\Controllers;


use App\Exceptions\UserAddCompanyServiceException;
use App\Exceptions\UserAuthServiceException;
use App\Exceptions\UserRecoveryPasswordServiceException;
use App\Exceptions\UserRegisterServiceException;
use App\Repositories\UserRepository;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    private UserRepository $repository;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['userRegister','userAuth','userRecoverPassword']]);
        $this->repository = new UserRepository();
    }

    public function userRegister(Request $request)
    {
        try {

            return response()->json(['success' => true, 'result' => $this->repository->userRegister($request)]);

        } catch (UserRegisterServiceException $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function userAuth(Request $request)
    {
        try {

            return response()->json(['success' => true, 'result' => $this->repository->userAuth($request)]);

        } catch (UserAuthServiceException $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function userRecoverPassword(Request $request)
    {
        try {

            return response()->json(['success' => true, 'result' => $this->repository->recoverPassword($request)]);

        } catch(UserRecoveryPasswordServiceException $e){

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function userFindCompanies(Request $request)
    {
        try {
            $this->repository->setUser($request->user());

            return response()->json(['success' => true, 'result' => $this->repository->getCompanies()]);

        } catch (\Exception $e){}

        return response()->json(['success' => false, 'message' => 'Failed!']);
    }

    public function userAddCompany(Request $request)
    {
        try {
            $this->repository->setUser($request->user());

            return response()->json(['success' => true, 'result' =>  $this->repository->addCompany($request)]);

        } catch (UserAddCompanyServiceException $e){}

        return response()->json(['success' => false, 'message' => 'Failed! ' . $e->getMessage() ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\ChildResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function userLogin(AuthRequest $request)
    {
        $responseData = $this->authService->userLogin($request->validated());
        return $this->successResponse(
            $responseData['user'],
            'UserSuccessfullySignedIn',
            null,
            200,
            $responseData['token']
        );
    }

    public function childLogin(AuthRequest $request)
    {
        $responseData = $this->authService->childLogin($request->validated());
        return $this->successResponse(
            $responseData['child'],
            'UserSuccessfullySignedIn',
            null,
            200,
            $responseData['token']
        );
    }

    public function userInfo()
    {
        $responseData = null;
        /**
        * @var Collection $userInfo
         */
        $userInfo = $this->authService->userInfo();
        $userInfo->load('attachment');

        if (Auth::guard('children')->check()) {
            $responseData  = $this->resource($userInfo, ChildResource::class);
        } else if (Auth::guard('users')->check()) {
            $responseData = $this->resource($userInfo, UserResource::class);
        }
        return $this->successResponse(
            $responseData,
            'UserInfoFetchedSuccessfully'
        );
    }

    public function updateParentPassword(AuthRequest $request)
    {
        return $this->successResponse(
            $this->authService->updateParentPassword($request->validated()),
            'PasswordChangedSuccessfully',
        );
    }

    public function updateChildProfile(AuthRequest $request)
    {
        return $this->successResponse(
            $this->authService->updateChildProfile($request->validated()),
            'UpdatedSuccessfully',
            'Account'
        );
    }

    public function logout()
    {
        return $this->successResponse(
            $this->authService->logout(),
            'UserSuccessfullySignedOut',
        );
    }


    public function updateAccountStatus(AuthRequest $request)
    {
        return $this->successResponse(
            $this->authService->updateAccountStatus($request->validated()),
            'UpdatedSuccessfully',
            'Account'
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Exception;
use App\Models\User;
use App\Services\AuthService;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{

    public function register(UserRegisterRequest $request, AuthService $service)
    {
        try {
            $fields = $request->validated();

            $service->register($fields['email'], $fields['password'], User::CUSTOMER);

            return ResponseHelper::success([
                'token' => $request->user()->createToken($request->input('device_name'))->accessToken,
                'user'  => $request->user(),
            ]);
        } catch (Exception $e) {
            return ResponseHelper::error($e);
        }
    }

    public function login(UserLoginRequest $request, AuthService $service)
    {
        try {
            $fields = $request->validated();
            $service->login($fields);
            return ResponseHelper::success([
                'token' => $request->user()->createToken($request->input('device_name'))->accessToken,
                'user'  => $request->user(),
            ]);
        } catch (Exception $e) {
            return ResponseHelper::error($e);
        }
    }

    public function logout(AuthService $service)
    {
        return $service->logout() ? ResponseHelper::success('logout success'): ResponseHelper::error(new Exception('logout failed'));
    }
}

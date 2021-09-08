<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Services\AuthService;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(UserRegisterRequest $request, AuthService $service)
    {
        try {
            $fields = $request->validated();

            $service->register($fields['email'], $fields['password'], User::CUSTOMER);

            return response()->json([
                'token' => $request->user()->createToken($request->input('device_name'))->accessToken,
                'user'  => $request->user(),
            ]);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }
            return $e->getMessage();
        }
    }

    public function login(UserLoginRequest $request, AuthService $service)
    {
        try {
            $fields = $request->validated();

            $service->login($fields, 1);

            return response()->json([
                'token' => $request->user()->createToken($request->input('device_name'))->accessToken,
                'user'  => $request->user(),
            ]);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }
            return $e->getMessage();
        }
    }

    public function logout(AuthService $service)
    {
        return $service->logout();
    }
}

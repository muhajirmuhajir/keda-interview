<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['email' => ['the credential is not match']]);
        }
    }

    public function register(string $email, $password, int $user_type = User::CUSTOMER)
    {
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'user_type_id' => $user_type,
        ]);

        Auth::login($user);
    }

    public function logout(): bool
    {
        try {
            $user = Auth::user()->token();
            $user->revoke();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

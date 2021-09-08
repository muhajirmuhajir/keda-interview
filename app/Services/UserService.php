<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function users($type = User::CUSTOMER, bool $withSoftDeletes = false)
    {
        $query = User::query();
        if($withSoftDeletes){
            $query->withTrashed();
        }
        return User::where('user_type_id', $type)->get();
    }

    public function deleteCustumer($id)
    {
        $user = User::findOrFail($id);
        if($user->user_type_id != User::CUSTOMER){
            throw ValidationException::withMessages(['user' => ['user is not customer']]);
        }
        return $user->delete();
    }

}

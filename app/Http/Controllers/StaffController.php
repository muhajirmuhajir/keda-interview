<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use App\Services\ConversationService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StaffController extends Controller
{
    public function allChatHistory(ConversationService $service)
    {
        if(!Gate::allows('view-all-chat')){
            return response('you are not allowed');
        }
        return $service->showAllConvesation();
    }

    public function allCustumers(UserService $service)
    {
        if(!Gate::allows('view-all-customer')){
            return response('you are not allowed');
        }
        return $service->users(User::CUSTOMER, true);
    }

    public function deleteCustumer($id, UserService $service)
    {
        try {
            if(!Gate::allows('delete-customer')){
                return response('you are not allowed');
            }
           return $service->deleteCustumer($id);
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }
            if ($e instanceof ModelNotFoundException) {
                return response()->json( ["message" => "Customer not found!"], 404);
            }
            return response()->json( ["message" => $e->getMessage()], 500);
        }

    }
}

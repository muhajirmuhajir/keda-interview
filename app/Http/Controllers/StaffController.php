<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Services\UserService;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Gate;
use App\Services\ConversationService;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StaffController extends Controller
{
    public function allChatHistory(ConversationService $service)
    {
        if (!Gate::allows('view-all-chat')) {
            return ResponseHelper::error(new HttpException(403, 'You are not allowed'));
        }
        return ResponseHelper::success($service->showAllConvesation());
    }

    public function allCustumers(UserService $service)
    {
        if (!Gate::allows('view-all-customer')) {
            return ResponseHelper::error(new HttpException(403, 'You are not allowed'));
        }
        return ResponseHelper::success($service->users(User::CUSTOMER, true));
    }

    public function deleteCustumer($id, UserService $service)
    {
        try {
            if (!Gate::allows('delete-customer')) {
                return ResponseHelper::error(new HttpException(403, 'You are not allowed'));
            }
            return $service->deleteCustumer($id) ? ResponseHelper::success('custumer deleted') : ResponseHelper::error(new Exception('failed to deleted'));
        } catch (Exception $e) {
            return ResponseHelper::error($e);
        }
    }
}

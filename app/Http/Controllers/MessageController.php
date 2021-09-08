<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\ResponseHelper;
use App\Services\ConversationService;
use App\Http\Requests\MessageStoreRequest;

class MessageController extends Controller
{
    public function createMessage(MessageStoreRequest $request, ConversationService $service)
    {
        try {
            $request->validated();
            $conversation = $service->create($request->receiver_id, $request->content, $request->type);
            return ResponseHelper::success($conversation);
        } catch (Exception $e) {
            return ResponseHelper::error($e);
        }
    }
}

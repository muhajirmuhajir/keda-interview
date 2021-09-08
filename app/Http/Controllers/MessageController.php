<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\ConversationService;
use App\Http\Requests\MessageStoreRequest;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    public function createMessage(MessageStoreRequest $request, ConversationService $service)
    {
        try {
            $request->validated();

            $conversation = $service->create($request->receiver_id, $request->content, $request->type);
            return $conversation;
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }
            return $e->getMessage();
        }
    }
}

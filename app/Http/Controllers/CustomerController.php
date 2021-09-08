<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\ReportService;
use App\Services\ConversationService;
use App\Http\Requests\ReportStoreRequest;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function chatHistory(ConversationService $service)
    {
        $chat_history = $service->showMyConversation();
        return $chat_history;
    }


    public function createReport(ReportStoreRequest $request, ReportService $service)
    {
        try {
            $report  = $service->create($request->validated());
            return $report;
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }
            return $e->getMessage();
        }
    }

}

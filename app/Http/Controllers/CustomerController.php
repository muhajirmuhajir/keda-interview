<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Exception;
use App\Services\ReportService;
use App\Services\ConversationService;
use App\Http\Requests\ReportStoreRequest;

class CustomerController extends Controller
{
    public function chatHistory(ConversationService $service)
    {
        $chat_history = $service->showMyConversation();
        return ResponseHelper::success($chat_history);
    }


    public function createReport(ReportStoreRequest $request, ReportService $service)
    {
        try {
            $report  = $service->create($request->validated());
            return ResponseHelper::success($report);
        } catch (Exception $e) {
           return ResponseHelper::error($e);
        }
    }

}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, CustomerController, MessageController, StaffController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);


    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', function (Request $request) {
            return $request->user();
        });

        Route::post('messages', [MessageController::class, 'createMessage'])->name('messages.create');
        Route::get('messages', [CustomerController::class, 'chatHistory'])->name('messages.index');

        Route::post('reports', [CustomerController::class, 'createReport'])->name('report.create');

        Route::get('messages/history', [StaffController::class, 'allChatHistory'])->name('messages.history');

        Route::get('customers', [StaffController::class, 'allCustumers'])->name('customers.index');

        Route::delete('customers/{id}', [StaffController::class, 'deleteCustumer'])->name('customers.delete');

        // Route::apiResource('conversations', ConversationController::class);
        // Route::apiResource('conversations.messages', ConversationController::class);
    });
});

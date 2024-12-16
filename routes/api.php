<?php

use App\Http\Controllers\Api\user_tasks\TaskController;
use App\Http\Controllers\Api\Login\UserLoginController;
use App\Http\Controllers\Api\Register\UserRegisterController;
use App\Http\Controllers\Api\User_Reports\ReportSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('register', [UserRegisterController::class, 'register']);
    Route::post('login', [UserLoginController::class, 'login']);
    Route::post('logout', [UserLoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
    Route::delete('tasks/batch', [TaskController::class, 'batchDelete'])->middleware('auth:sanctum');
    Route::post('tasks/restore-last', [TaskController::class, 'restoreLast'])->middleware('auth:sanctum');
    Route::post('subscribe', [ReportSubscriptionController::class, 'subscribe'])->middleware('auth:sanctum');
    Route::post('unsubscribe', [ReportSubscriptionController::class, 'unsubscribe'])->middleware('auth:sanctum');
});

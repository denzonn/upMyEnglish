<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GetDataController;
use App\Http\Controllers\Api\UserAnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function() {
    Route::get('materi', [GetDataController::class, 'materi']);
    Route::get('submateri/{materi_id}', [GetDataController::class, 'submateri']);
    Route::get('submateri/detail/{sub_materi_id}', [GetDataController::class, 'submateriDetail']);
    Route::get('question/{submateri_id}', [GetDataController::class, 'question']);
    Route::get('answer/{question_id}', [GetDataController::class, 'answer']);
    Route::get('user_answer', [UserAnswerController::class, 'index']);

    Route::post('user-answer', [UserAnswerController::class, 'store']);
});

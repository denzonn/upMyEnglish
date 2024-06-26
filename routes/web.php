<?php

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubMateriController;
use App\Http\Controllers\Admin\UserAnswerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('redirectIfAuth');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('materi', MateriController::class);
    Route::resource('submateri', SubMateriController::class);
    Route::resource('question', QuestionController::class);

    Route::get('example/{id}', [SubMateriController::class, 'example'])->name('example-edit');
    Route::put('example/update/{id}', [SubMateriController::class, 'updateExample'])->name('example-update');

    //Answer
    Route::get('answer/{question_id}', [AnswerController::class, 'index'])->name('answer-index');
    Route::get('answer/create/{question_id}', [AnswerController::class, 'create'])->name('answer-create');
    Route::post('answer/store', [AnswerController::class, 'store'])->name('answer-store');
    Route::get('answer/edit/{id}', [AnswerController::class, 'edit'])->name('answer-edit');
    Route::put('answer/update/{id}', [AnswerController::class, 'update'])->name('answer-update');
    Route::delete('answer/delete/{id}', [AnswerController::class, 'destroy'])->name('answer-destroy');

    //User Answer
    Route::get('user-answer', [UserAnswerController::class, 'index'])->name('user-answer-index');
    Route::get('user-answer/sub_materi/{user_id}', [UserAnswerController::class, 'submateri'])->name('user-answer-submateri');
    Route::get('user-answer/detail-answer/{user_answer}', [UserAnswerController::class, 'detail'])->name('user-answer-detail');

    Route::get('user-answer/sub_materi/{user_id}/data', [UserAnswerController::class, 'getDataSubMateri'])->name('user-answer.submateri-data');
    Route::get('get-materi', [MateriController::class, 'getData'])->name('materiData');
    Route::get('get-submateri', [SubMateriController::class, 'getData'])->name('submateriData');
    Route::get('get-question', [QuestionController::class, 'getData'])->name('questionData');
    Route::get('get-answer/{question_id}', [AnswerController::class, 'getData'])->name('answerData');
    Route::get('get-user', [UserAnswerController::class, 'getData'])->name('userAnswerData');
});

require __DIR__ . '/auth.php';

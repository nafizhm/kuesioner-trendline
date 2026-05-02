<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\UserSettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SuggestionController::class, 'index'])->name('suggestions.index');
Route::post('/', [SuggestionController::class, 'store'])->name('suggestions.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/data-kuesioner', [QuestionnaireController::class, 'index'])->name('questionnaires.index');
    Route::delete('/data-kuesioner/{suggestion}', [QuestionnaireController::class, 'destroy'])->name('questionnaires.destroy');
    Route::get('/pengaturan-pertanyaan', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/pengaturan-pertanyaan', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/pengaturan-pertanyaan/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/pengaturan-pertanyaan/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::get('/pengaturan-pengguna', [UserSettingsController::class, 'index'])->name('users.index');
    Route::post('/pengaturan-pengguna', [UserSettingsController::class, 'store'])->name('users.store');
    Route::put('/pengaturan-pengguna/{user}', [UserSettingsController::class, 'update'])->name('users.update');
    Route::delete('/pengaturan-pengguna/{user}', [UserSettingsController::class, 'destroy'])->name('users.destroy');
});

<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/policy', [HomeController::class, 'policy'])->name('policy');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'completeRegistration'])->name('register.complete');
Route::post('register/complete', [RegisterController::class, 'completeRegistration'])->name('register.finalize');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Auth::routes(['verify' => true]);

// Показ формы для ввода email
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Отправка ссылки на сброс пароля
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Показ формы сброса пароля с токеном
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Обработка сброса пароля
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Auth::routes();

// Group the routes that require authentication
Route::middleware('auth')->group(function () {
    Route::post('/offlineModal', [ProfileController::class, 'offlineModal'])->name('offlineModal');
    Route::post('/profileedit', [ProfileController::class, 'profileedit'])->name('profileedit');
    Route::post('/profileDelete', [ProfileController::class, 'profileDelete'])->name('profileDelete');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/register-quiz/{id}', [RegController::class, 'registerquiz'])->name('registerquiz');
    Route::post('/registerquizCommand/{id}', [RegController::class, 'registerquizCommand'])->name('registerquizCommand');

    Route::get('/register-group/{id}', [RegController::class, 'registerGroup'])->name('register.group');
    Route::post('/registerGroupCommand/{id}', [RegController::class, 'registerGroupCommand'])->name('registerGroupCommand');
    Route::get('/thanky/{id}', [RegController::class, 'thanky'])->name('thanky');
    Route::get('/register-solo/{id}', [RegController::class, 'registerSolo'])->name('register.solo');
    Route::post('/register-solo/{id}', [RegController::class, 'registerSoloCommand'])->name('registerSoloCommand');

    Route::middleware(['auth', 'admin'])->group(function () {
        // Маршрут для отправки писем пользователям по диапазону ID
        Route::get('/send-emails', [EmailController::class, 'sendEmails'])->name('send.emails');

        // Маршрут для отправки писем всем пользователям из таблицы solo_registrations
        Route::get('/send-emails/solo', [EmailController::class, 'sendEmailsToAllSoloRegistrations'])->name('send.emails.solo');

        Route::get('update-participants-encoding', [EmailController::class, 'updateParticipantsEncoding']);



        Route::get('/send-emails/team-registrations', [EmailController::class, 'sendEmailsToAllTeamRegistrations'])
            ->name('sendEmailsToAllTeamRegistrations');
    });
});
// /send-emails

// /send-emails/solo

// /send-emails/team-registrations

// Условие для принудительного использования HTTPS в production
if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

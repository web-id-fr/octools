<?php

use Webid\Octools\Http\Controllers\Auth\AuthenticatedSessionController;
use Webid\Octools\Http\Controllers\Auth\ConfirmablePasswordController;
use Webid\Octools\Http\Controllers\Auth\EmailVerificationNotificationController;
use Webid\Octools\Http\Controllers\Auth\EmailVerificationPromptController;
use Webid\Octools\Http\Controllers\Auth\NewPasswordController;
use Webid\Octools\Http\Controllers\Auth\PasswordController;
use Webid\Octools\Http\Controllers\Auth\PasswordResetLinkController;
use Webid\Octools\Http\Controllers\Auth\RegisteredUserController;
use Webid\Octools\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('inscription', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('inscription', [RegisteredUserController::class, 'store']);

    Route::get('connexion', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('connexion', [AuthenticatedSessionController::class, 'store']);

    Route::get('mot-de-passe-oublie', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('mot-de-passe-oublie', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reinitialiser-mot-de-passe/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reinitialiser-mot-de-passe', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verification-adresse-electronique', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verification-adresse-electronique/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

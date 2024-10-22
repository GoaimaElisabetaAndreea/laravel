<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;

// Home Route
Route::get('/', [App\Http\Controllers\Controller::class, 'home'])->name('home');

Route::get('user/{username}',[App\Http\Controllers\ProfileController::class,'user'])->name('profile-user');


// Authenticated routes
Route::middleware('auth')->group(function(){

    Route::post('account/change-password',[AccountController::class, 'postChangePassword'])->name('account-change-password-post');
    //Change passwprd (GET)
    Route::get('account/change-password',[AccountController::class,'getChangePassword'])->name('account-change-password');

    //Sign out (GET)
    Route::get('/account/sign-out',[AccountController::class,'getSignOut'])->name('account-sign-out');
});


// Unauthenticated routes
Route::middleware('guest')->group(function () {

    // CSRF protection is automatically applied to POST routes in Laravel
    Route::post('account/create', [AccountController::class, 'postCreate'])->name('account-create-post');
    Route::post('account/sign-in', [AccountController::class, 'postSignIn'])->name('account-sign-in-post');
    Route::post('account/forgot-password', [AccountController::class, 'postForgotPassword'])->name('account-forgot-password-post');

    // Public routes
    Route::get('/account/sign-in', [AccountController::class, 'getSignIn'])->name('account-sign-in');
    Route::get('/account/create', [AccountController::class, 'getCreate'])->name('account-create');
    Route::get('/account/activate/{code}', [AccountController::class, 'getActivate'])->name('account-activate');
    Route::get('/account/forgot-password', [AccountController::class,'getForgotPassword'])->name('account-forgot-password');
    Route::get('account/recover/{code}',[AccountController::class,'getRecover'])->name('account-recover');
});

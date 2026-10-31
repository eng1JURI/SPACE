<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuoteController::class, 'index'])->name('home');
Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('guest')->group(function () {
    Route::get('/signup', fn () => view('Authentication.SignUp', ['page' => 'Sign Up']))->name('signup');
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup.store');
    Route::get('/login', fn () => view('Authentication.LogIn', ['page' => 'Log In']))->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/quote', [QuoteController::class, 'store'])->name('quotes.store');
    Route::put('/quote/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
    Route::delete('/quote/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
    Route::post('/quote/{quote}/like', [QuoteController::class, 'toggleLike'])->name('quotes.like');
    Route::get('/likes', [QuoteController::class, 'likes'])->name('likes');
    Route::get('/my-space', [QuoteController::class, 'mine'])->name('my-space');
    Route::get('/profile', [ProfileController::class, 'me'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::view('/maintenance', 'errors.503'); // preview of the maintenance page (remove before launch if you like)

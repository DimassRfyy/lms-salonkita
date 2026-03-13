<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/course', [HomeController::class, 'course'])->name('course');

Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

Route::get('/savedCourses', [HomeController::class, 'savedCourses'])->name('saved-courses');

Route::get('/all-courses', [HomeController::class, 'allCourses'])->name('all-courses');

Route::get('/task', [HomeController::class, 'task'])->name('task');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post')->middleware('guest');

Route::get('/register', [RegisterController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

Route::get('/transaction', [HomeController::class, 'transaction'])->name('transaction')->middleware('auth');

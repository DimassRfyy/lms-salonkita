<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/course/{slug?}', [HomeController::class, 'course'])->name('course');
Route::post('/course/{slug}/task-submission', [HomeController::class, 'storeCourseTaskSubmission'])
    ->name('course.task-submission.store')
    ->middleware('auth');

Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

Route::get('/savedCourses', [HomeController::class, 'savedCourses'])->name('saved-courses')->middleware('auth');
Route::post('/savedCourses/{course}', [HomeController::class, 'storeSavedCourse'])->name('saved-courses.store')->middleware('auth');
Route::delete('/savedCourses/{course}', [HomeController::class, 'destroySavedCourse'])->name('saved-courses.destroy')->middleware('auth');

Route::get('/all-courses', [HomeController::class, 'allCourses'])->name('all-courses');

Route::get('/task', [HomeController::class, 'task'])->name('task')->middleware('auth');

Route::get('/claim-certificate/{slug}', [HomeController::class, 'claimCertificate'])->name('claim-certificate')->middleware('auth');

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
Route::post('/transaction', [HomeController::class, 'storeTransaction'])->name('transaction.store')->middleware('auth');

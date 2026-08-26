<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MentoringController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/course/{slug?}', [HomeController::class, 'course'])->name('course');
Route::post('/course/{slug}/quiz/submit', [HomeController::class, 'storeCourseVideoQuiz'])
    ->name('course.quiz.submit')
    ->middleware('auth');
Route::post('/course/{slug}/task-submission', [HomeController::class, 'storeCourseTaskSubmission'])
    ->name('course.task-submission.store')
    ->middleware('auth');
Route::post('/course/{slug}/discussion', [HomeController::class, 'storeCourseDiscussion'])
    ->name('course.discussion.store')
    ->middleware('auth');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

// FITUR REDEEM POINT DI-DISABLE SEMENTARA
// Route::get('/points', [PointController::class, 'index'])->name('points.index')->middleware('auth');
// Route::post('/points/redeem/{rewardItem}', [PointController::class, 'redeem'])->name('points.redeem')->middleware('auth');

Route::get('/savedCourses', [HomeController::class, 'savedCourses'])->name('saved-courses')->middleware('auth');
Route::post('/savedCourses/{course}', [HomeController::class, 'storeSavedCourse'])->name('saved-courses.store')->middleware('auth');
Route::delete('/savedCourses/{course}', [HomeController::class, 'destroySavedCourse'])->name('saved-courses.destroy')->middleware('auth');

Route::get('/all-courses', [HomeController::class, 'allCourses'])->name('all-courses');

Route::get('/mentoring', [MentoringController::class, 'index'])
    ->name('mentoring.index')
    ->middleware('auth');
Route::get('/mentoring/mentors', [MentoringController::class, 'mentors'])
    ->name('mentoring.mentors')
    ->middleware('auth');
Route::post('/mentoring/{entitlement}/apply', [MentoringController::class, 'apply'])
    ->name('mentoring.apply')
    ->middleware('auth');
Route::post('/mentoring/requests/{mentoringRequest}/cancel', [MentoringController::class, 'cancelRequest'])
    ->name('mentoring.request.cancel')
    ->middleware('auth');
Route::post('/mentoring/terminate', [MentoringController::class, 'terminateMentorship'])
    ->name('mentoring.terminate')
    ->middleware('auth');
Route::get('/mentoring/book', [MentoringController::class, 'book'])
    ->name('mentoring.book')
    ->middleware('auth');
Route::get('/mentoring/{entitlement}/book', [MentoringController::class, 'book'])
    ->name('mentoring.book.entitlement')
    ->middleware('auth');
Route::post('/mentoring/{entitlement}/book', [MentoringController::class, 'store'])
    ->name('mentoring.store')
    ->middleware('auth');

Route::get('/task', [HomeController::class, 'task'])->name('task')->middleware('auth');

Route::get('/claim-certificate/{slug}', [HomeController::class, 'claimCertificate'])->name('claim-certificate')->middleware('auth');
Route::post('/course/{slug}/review', [HomeController::class, 'storeCourseReviewAndClaim'])->name('course.review.store')->middleware('auth');
Route::get('/course/{slug}/certificate/download', [HomeController::class, 'downloadCertificate'])->name('certificate.download')->middleware('auth');
Route::get('/course/{slug}/certificate/view', [HomeController::class, 'viewCertificate'])->name('certificate.view')->middleware('auth');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post')->middleware('guest');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect')->middleware('guest');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback')->middleware('guest');

Route::get('/register', [RegisterController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post')->middleware('guest');

Route::get('/register/mentor-coach/{role?}', [RegisterController::class, 'mentorCoachRegister'])
    ->name('register.mentor-coach')
    ->whereIn('role', ['mentor', 'coach'])
    ->middleware('guest');

Route::post('/register/mentor-coach', [RegisterController::class, 'storeMentorCoach'])
    ->name('register.mentor-coach.store')
    ->middleware('guest');

Route::get('/mentor-coach/complete-profile', [ProfileController::class, 'mentorCoachProfile'])
    ->name('mentor-coach.profile')
    ->middleware('auth');
    
Route::post('/mentor-coach/complete-profile', [ProfileController::class, 'update'])
    ->name('mentor-coach.profile.update')
    ->middleware('auth');

Route::get('/mentor-coach/waiting', [ProfileController::class, 'mentorCoachWaiting'])
    ->name('mentor-coach.waiting')
    ->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

Route::get('/transaction', [PaymentController::class, 'transaction'])->name('transaction')->middleware('auth');
Route::post('/transaction', [PaymentController::class, 'storeTransaction'])->name('transaction.store')->middleware('auth');

Route::post('/payments/xendit/webhook', [PaymentController::class, 'notification'])
    ->name('payments.xendit.webhook')
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/payments/xendit/finish', [PaymentController::class, 'finish'])
    ->name('payments.xendit.finish');

Route::get('/payments/xendit/unfinish', [PaymentController::class, 'unfinish'])
    ->name('payments.xendit.unfinish');

Route::get('/payments/xendit/error', [PaymentController::class, 'error'])
    ->name('payments.xendit.error');


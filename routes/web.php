<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Quiz routes
    Route::resource('quizzes', QuizController::class);

    // Question routes
    Route::get('quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    // Quiz attempt routes
    Route::get('quizzes/{quiz}/take', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('quizzes/{quiz}/attempts/{attempt}/answers', [QuizAttemptController::class, 'storeAnswer'])->name('attempts.answers.store');
    Route::get('quizzes/{quiz}/attempts/{attempt}/results', [QuizAttemptController::class, 'results'])->name('quizzes.results');
    Route::post('quizzes/{quiz}/restart', [QuizAttemptController::class, 'restart'])->name('quizzes.restart');
});

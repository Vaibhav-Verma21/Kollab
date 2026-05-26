<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/catalog', [CourseController::class, 'index'])->name('catalog');

Route::get('/my-courses', [CourseController::class, 'myEnrolled'])
    ->middleware('auth')
    ->name('my-courses');

Route::middleware('auth')->group(function () {
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace');
    Route::post('/workspace/sync', [WorkspaceController::class, 'sync'])->name('workspace.sync');
    Route::post('/workspace/clear', [WorkspaceController::class, 'clear'])->name('workspace.clear');
    
    // Enrollment
    Route::post('/enroll/{courseId}', [EnrollmentController::class, 'store'])->name('enroll.store');
    
    // Forum specific routes for auth users
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{id}/reply', [ForumController::class, 'reply'])->name('forum.reply');
});

Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course');

Route::post('/notes', [NoteController::class, 'save'])
    ->middleware('auth')
    ->name('notes.save');

// Forum public routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');

Route::get('/assignment', function () {
    return view('assignment');
})->name('assignment');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


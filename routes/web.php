<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\PeerReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;

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
    Route::get('/workspace/{uuid}', [WorkspaceController::class, 'show'])->name('workspace.show');
    Route::post('/workspace/{uuid}/sync', [WorkspaceController::class, 'sync'])->name('workspace.sync');
    Route::post('/workspace/{uuid}/clear', [WorkspaceController::class, 'clear'])->name('workspace.clear');
    
    // Enrollment
    Route::post('/enroll/{courseId}', [EnrollmentController::class, 'store'])->name('enroll.store');
    
    // Forum specific routes for auth users
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{id}/reply', [ForumController::class, 'reply'])->name('forum.reply');
});

Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course');

Route::middleware('auth')->group(function () {
    Route::get('/course/{slug}/quiz', [QuizController::class, 'show'])->name('course.quiz');
    Route::post('/course/{slug}/quiz', [QuizController::class, 'submit'])->name('course.quiz.submit');

    // Assignments & Peer Reviews
    Route::get('/course/{slug}/assignment/{id}', [AssignmentController::class, 'show'])->name('course.assignment');
    Route::post('/course/{slug}/assignment/{id}', [AssignmentController::class, 'submit'])->name('course.assignment.submit');

    Route::get('/peer-reviews', [PeerReviewController::class, 'index'])->name('peer_reviews.index');
    Route::get('/peer-reviews/{id}', [PeerReviewController::class, 'show'])->name('peer_reviews.show');
    Route::post('/peer-reviews/{id}', [PeerReviewController::class, 'submit'])->name('peer_reviews.submit');
});

Route::post('/notes', [NoteController::class, 'save'])
    ->middleware('auth')
    ->name('notes.save');

// Forum public routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');

    Route::get('/assignments/create', [AdminAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AdminAssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments', [AdminAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{id}/submissions', [AdminAssignmentController::class, 'submissions'])->name('assignments.submissions');
    Route::post('/submissions/{id}/grade', [AdminAssignmentController::class, 'grade'])->name('submissions.grade');
});

require __DIR__.'/auth.php';


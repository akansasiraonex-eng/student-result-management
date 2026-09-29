<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\CourseAssignmentController;
use App\Http\Controllers\Admin\CourseEnrollmentController;

use App\Http\Controllers\Lecturer\DashboardController as LecturerDashboardController;
use App\Http\Controllers\Lecturer\ResultController as LecturerResultController;

use App\Http\Controllers\Registrar\DashboardController as RegistrarDashboardController;
use App\Http\Controllers\Registrar\ResultApprovalController;

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ResultController as StudentResultController;

use App\Http\Controllers\Finance\DashboardController as FinanceDashboardController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| General Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('/admin/courses', CourseController::class)
        ->names('admin.courses');

    Route::resource('/admin/academic-years', AcademicYearController::class)
        ->names('admin.academic-years');

    Route::resource('/admin/semesters', SemesterController::class)
        ->names('admin.semesters');

    Route::resource('/admin/course-assignments', CourseAssignmentController::class)
        ->names('admin.course-assignments');
});


/*
|--------------------------------------------------------------------------
| Admin and Registrar Course Enrollment Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,registrar'])->group(function () {

    Route::resource('/admin/course-enrollments', CourseEnrollmentController::class)
        ->names('admin.course-enrollments');
});


/*
|--------------------------------------------------------------------------
| Lecturer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:lecturer'])->group(function () {

    Route::get('/lecturer/dashboard', [LecturerDashboardController::class, 'index'])
        ->name('lecturer.dashboard');

    Route::resource('/lecturer/results', LecturerResultController::class)
        ->names('lecturer.results');

    Route::post(
        '/lecturer/results/{result}/submit',
        [LecturerResultController::class, 'submit']
    )->name('lecturer.results.submit');
});


/*
|--------------------------------------------------------------------------
| Registrar Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:registrar'])->group(function () {

    Route::get('/registrar/dashboard', [RegistrarDashboardController::class, 'index'])
        ->name('registrar.dashboard');
});


/*
|--------------------------------------------------------------------------
| Registrar Result Approval Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:registrar,admin'])->group(function () {

    Route::resource('/registrar/result-approvals', ResultApprovalController::class)
        ->only(['index', 'show'])
        ->parameters([
            'result-approvals' => 'result',
        ])
        ->names('registrar.result-approvals');

    Route::post(
        '/registrar/result-approvals/{result}/approve',
        [ResultApprovalController::class, 'approve']
    )->name('registrar.result-approvals.approve');

    Route::post(
        '/registrar/result-approvals/{result}/reject',
        [ResultApprovalController::class, 'reject']
    )->name('registrar.result-approvals.reject');

    Route::post(
        '/registrar/result-approvals/{result}/return',
        [ResultApprovalController::class, 'returnToLecturer']
    )->name('registrar.result-approvals.return');

    Route::post(
        '/registrar/result-approvals/{result}/publish',
        [ResultApprovalController::class, 'publish']
    )->name('registrar.result-approvals.publish');
});


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

    Route::get(
        '/student/results',
        [StudentResultController::class, 'index']
    )->name('student.results.index');

    Route::get(
        '/student/results/{courseEnrollment}',
        [StudentResultController::class, 'show']
    )->name('student.results.show');

    Route::get('/student/transcript', [StudentResultController::class, 'transcript'])
    ->name('student.transcript');
});


/*
|--------------------------------------------------------------------------
| Finance Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:finance'])->group(function () {

    Route::get('/finance/dashboard', [FinanceDashboardController::class, 'index'])
        ->name('finance.dashboard');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
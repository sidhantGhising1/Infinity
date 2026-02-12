<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\CounselorController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FeeStructureController;
use App\Http\Controllers\ConsultancyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\AdminProfileController;
use Illuminate\Support\Facades\Route;


Route::any('/ping', function () {
    return response()->json([
        'pong' => true,
        'method' => request()->method(),
    ]);
});


// Public Routes
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login');


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', function () {
        return auth()->user();
    })->name('profile');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // Users routes
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store'])
            ->name('users.store');
        Route::put('/{user}', [UserController::class, 'update'])
            ->name('users.update');
        Route::patch('/{user}/status', [UserController::class, 'userStatus'])
            ->name('users.status');
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    // Students routes
    Route::prefix('students')->group(function () {
        Route::post('/', [StudentController::class, 'store'])
            ->name('students.store');
        Route::get('/{student}', [StudentController::class, 'show'])
            ->name('students.show');
        Route::put('/{student}', [StudentController::class, 'update'])
            ->name('students.update');
        Route::patch('/{student}/status', [StudentController::class, 'studentStatus'])
            ->name('students.status');
        Route::get('/', [StudentController::class, 'index'])
            ->name('students.index');
        Route::delete('/{student}', [StudentController::class, 'destroy'])
            ->name('students.destroy');
    });

    // Universities routes
    Route::prefix('universities')->group(function () {
        Route::post('/', [UniversityController::class, 'store'])
            ->name('universities.store');
        Route::get('/{university}', [UniversityController::class, 'show'])
            ->name('universities.show');
        Route::put('/{university}', [UniversityController::class, 'update'])
            ->name('universities.update');
        Route::patch('/{university}/status', [UniversityController::class, 'universityStatus'])
            ->name('universities.status');
        Route::get('/', [UniversityController::class, 'index'])
            ->name('universities.index');
        Route::delete('/{university}', [UniversityController::class, 'destroy'])
            ->name('universities.destroy');
    });

    // Consultancies routes
    Route::prefix('consultancies')->group(function () {
        Route::post('/', [ConsultancyController::class, 'store'])
            ->name('consultancies.store');
        Route::get('/{consultancy}', [ConsultancyController::class, 'show'])
            ->name('consultancies.show');
        Route::put('/{consultancy}', [ConsultancyController::class, 'update'])
            ->name('consultancies.update');
        Route::patch('/{consultancy}/status', [ConsultancyController::class, 'consultancyStatus'])
            ->name('consultancies.status');
        Route::get('/', [ConsultancyController::class, 'index'])
            ->name('consultancies.index');
        Route::delete('/{consultancy}', [ConsultancyController::class, 'destroy'])
            ->name('consultancies.destroy');
    });

    // Courses routes
    Route::prefix('courses')->group(function () {
        Route::post('/', [CourseController::class, 'store'])
            ->name('courses.store');
        Route::get('/{id}', [CourseController::class, 'show'])
            ->name('courses.show');
        Route::put('/{id}', [CourseController::class, 'update'])
            ->name('courses.update');
        Route::patch('/{id}/status', [CourseController::class, 'toggleStatus'])
            ->name('courses.status');
        Route::get('/', [CourseController::class, 'index'])
            ->name('courses.index');
        Route::delete('/{id}', [CourseController::class, 'destroy'])
            ->name('courses.destroy');
    });

    // Counselors routes
    Route::prefix('counselors')->group(function () {
        Route::post('/', [CounselorController::class, 'store'])
            ->name('counselors.store');
        Route::get('/{id}', [CounselorController::class, 'show'])
            ->name('counselors.show');
        Route::put('/{id}', [CounselorController::class, 'update'])
            ->name('counselors.update');
        Route::patch('/{id}/status', [CounselorController::class, 'toggleStatus'])
            ->name('counselors.status');
        Route::get('/', [CounselorController::class, 'index'])
            ->name('counselors.index');
        Route::delete('/{id}', [CounselorController::class, 'destroy'])
            ->name('counselors.destroy');
    });

    // Fee Structure routes
    Route::prefix('fee-structures')->group(function () {
        Route::post('/', [FeeStructureController::class, 'store'])
            ->name('fee-structures.store');
        Route::get('/{id}', [FeeStructureController::class, 'show'])
            ->name('fee-structures.show');
        Route::put('/{id}', [FeeStructureController::class, 'update'])
            ->name('fee-structures.update');
        Route::get('/', [FeeStructureController::class, 'index'])
            ->name('fee-structures.index');
        Route::delete('/{id}', [FeeStructureController::class, 'destroy'])
            ->name('fee-structures.destroy');
    });

    // Role Routes
    Route::prefix('roles')->group(function () {

        Route::get('/', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::post('/', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/{id}', [RoleController::class, 'show'])
            ->name('roles.show');

        Route::put('/{id}', [RoleController::class, 'update'])
            ->name('roles.update');

        Route::delete('/{id}', [RoleController::class, 'destroy'])
            ->name('roles.destroy');

        Route::get('/{id}/permissions', [RoleController::class, 'permissions'])
            ->name('roles.permissions');

        Route::put('/{id}/permissions', [RoleController::class, 'assignPermissions'])
            ->name('roles.assign-permissions');

    });

    // Admin Profile Routes
    Route::prefix('admin')->group(function () {

        Route::get('/profile/{id}', [AdminProfileController::class, 'show'])
            ->name('admin.profile.show');

        Route::put('/profile/{id}', [AdminProfileController::class, 'update'])
            ->name('admin.profile.update');

        Route::put('/profile/{id}/change-password', [AdminProfileController::class, 'changePassword'])
            ->name('admin.profile.change-password');

    });


});


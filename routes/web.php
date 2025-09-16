<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\FinanceDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Page d'accueil
Route::view('/', 'welcome');

// Inscription étudiant
Route::get('/register', [StudentController::class, 'create'])->name('register');
Route::post('/register', [StudentController::class, 'store'])->name('register.store');
Route::get('/recap/{id}', [StudentController::class, 'recap'])->name('recap');

// Authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard général (redirige selon le rôle)
Route::middleware(['auth'])->get('/dashboard', function () {
    if (auth()->user()->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }
    // Ajoute ici d'autres redirections selon les rôles
    return redirect()->route('home');
})->name('dashboard');

// Dashboard SuperAdmin
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    // Gestion des cours
    Route::prefix('superadmin/courses')->name('superadmin.courses.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'coursesList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createCourse'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeCourse'])->name('store');
        Route::get('/{course}/edit', [SuperAdminController::class, 'editCourse'])->name('edit');
        Route::put('/{course}', [SuperAdminController::class, 'updateCourse'])->name('update');
        Route::delete('/{course}', [SuperAdminController::class, 'destroyCourse'])->name('destroy');
        Route::get('/{course}', [SuperAdminController::class, 'showCourse'])->name('show');
    });

    // Gestion des enseignants
    Route::prefix('superadmin/teachers')->name('superadmin.teachers.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'teachersList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createTeacher'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeTeacher'])->name('store');
        Route::get('/{teacher}/edit', [SuperAdminController::class, 'editTeacher'])->name('edit');
        Route::put('/{teacher}', [SuperAdminController::class, 'updateTeacher'])->name('update');
        Route::delete('/{teacher}', [SuperAdminController::class, 'destroyTeacher'])->name('destroy');
    });

    // Gestion des utilisateurs
    Route::prefix('superadmin/users')->name('superadmin.users.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'usersList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createUser'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeUser'])->name('store');
        Route::get('/{user}/edit', [SuperAdminController::class, 'editUser'])->name('edit');
        Route::put('/{user}', [SuperAdminController::class, 'updateUser'])->name('update');
        Route::delete('/{user}', [SuperAdminController::class, 'destroyUser'])->name('destroy');
    });

    // Gestion des mentions
    Route::prefix('superadmin/mentions')->name('superadmin.mentions.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'mentionsList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createMention'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeMention'])->name('store');
        Route::get('/{mention}/edit', [SuperAdminController::class, 'editMention'])->name('edit');
        Route::put('/{mention}', [SuperAdminController::class, 'updateMention'])->name('update');
        Route::delete('/{mention}', [SuperAdminController::class, 'destroyMention'])->name('destroy');
        Route::get('/{mention}', [SuperAdminController::class, 'showMention'])->name('show');
    });

    // Gestion des étudiants
    Route::prefix('superadmin/students')->name('superadmin.students.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'studentsList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createStudent'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeStudent'])->name('store');
        Route::get('/{student}/edit', [SuperAdminController::class, 'editStudent'])->name('edit');
        Route::put('/{student}', [SuperAdminController::class, 'updateStudent'])->name('update');
        Route::delete('/{student}', [SuperAdminController::class, 'destroyStudent'])->name('destroy');
        Route::get('/{student}', [SuperAdminController::class, 'showStudent'])->name('show');
        Route::get('/{student}/add-course', [SuperAdminController::class, 'addCourseToStudent'])->name('courses.add');
        Route::post('/{student}/add-course', [SuperAdminController::class, 'storeCourseToStudent'])->name('courses.store');
        Route::patch('/{student}/courses/{course}/remove', [SuperAdminController::class, 'removeCourseFromStudent'])->name('courses.remove');
        Route::get('/{student}/courses/history', [SuperAdminController::class, 'showStudentCourses'])->name('courses.history');
    });
   
    // Paramètres globaux
    Route::get('/superadmin/settings', function () {
        return view('superadmin.settings');})->name('superadmin.settings');
    Route::put('/superadmin/settings', [SuperAdminController::class, 'updateSettings'])->name('superadmin.settings.update');


    // Gestion des finances étudiantes
    Route::prefix('superadmin/finances')->name('superadmin.finances.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'financesList'])->name('list');
        Route::get('/create', [SuperAdminController::class, 'createFinance'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeFinance'])->name('store');
        Route::get('/{finance}/edit', [SuperAdminController::class, 'editFinance'])->name('edit');
        Route::put('/{finance}', [SuperAdminController::class, 'updateFinance'])->name('update');
        Route::delete('/{finance}', [SuperAdminController::class, 'destroyFinance'])->name('destroy');
    });

    // Gestion des détails de finances
    Route::resource('financedetails', FinanceDetailController::class)->names('superadmin.financedetails');
});

// Gestion des utilisateurs
Route::resource('users', UserController::class)->except(['edit', 'update', 'destroy']);
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Gestion des étudiants
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// API pour charger les parcours d'une mention (AJAX)
Route::get('/parcours/by-mention/{mentionId}', [ParcoursController::class, 'getByMention']);
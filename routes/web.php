<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;

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
    Route::get('/superadmin/courses', [SuperAdminController::class, 'coursesList'])->name('superadmin.courses.list');
    Route::get('/superadmin/courses/create', [SuperAdminController::class, 'createCourse'])->name('superadmin.courses.create');
    Route::post('/superadmin/courses/store', [SuperAdminController::class, 'storeCourse'])->name('superadmin.courses.store');
    Route::get('/superadmin/courses/{course}/edit', [SuperAdminController::class, 'editCourse'])->name('superadmin.courses.edit');
    Route::put('/superadmin/courses/{course}', [SuperAdminController::class, 'updateCourse'])->name('superadmin.courses.update');
    Route::delete('/superadmin/courses/{course}', [SuperAdminController::class, 'destroyCourse'])->name('superadmin.courses.destroy');
    Route::get('/superadmin/courses/{course}', [SuperAdminController::class, 'showCourse'])->name('superadmin.courses.show');
    // Gestion des enseignants
    Route::get('/superadmin/teachers', [SuperAdminController::class, 'teachersList'])->name('superadmin.teachers.list');
    Route::get('/superadmin/teachers/create', [SuperAdminController::class, 'createTeacher'])->name('superadmin.teachers.create');
    Route::post('/superadmin/teachers', [SuperAdminController::class, 'storeTeacher'])->name('superadmin.teachers.store');
    Route::get('/superadmin/teachers/{teacher}/edit', [SuperAdminController::class, 'editTeacher'])->name('superadmin.teachers.edit');
    Route::put('/superadmin/teachers/{teacher}', [SuperAdminController::class, 'updateTeacher'])->name('superadmin.teachers.update');
    Route::delete('/superadmin/teachers/{teacher}', [SuperAdminController::class, 'destroyTeacher'])->name('superadmin.teachers.destroy');
    // Gestion des utilisateurs
    Route::get('/superadmin/users', [SuperAdminController::class, 'usersList'])->name('superadmin.users.list');
    Route::get('/superadmin/users/create', [SuperAdminController::class, 'createUser'])->name('superadmin.users.create');
    Route::post('/superadmin/users', [SuperAdminController::class, 'storeUser'])->name('superadmin.users.store');
    Route::get('/superadmin/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('superadmin.users.edit');
    Route::put('/superadmin/users/{user}', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
    Route::delete('/superadmin/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('superadmin.users.destroy');
    // Gestion des mentions
    Route::get('/superadmin/mentions', [SuperAdminController::class, 'mentionsList'])->name('superadmin.mentions.list');
    Route::get('/superadmin/mentions/create', [SuperAdminController::class, 'createMention'])->name('superadmin.mentions.create');
    Route::post('/superadmin/mentions', [SuperAdminController::class, 'storeMention'])->name('superadmin.mentions.store');
    Route::get('/superadmin/mentions/{mention}/edit', [SuperAdminController::class, 'editMention'])->name('superadmin.mentions.edit');
    Route::put('/superadmin/mentions/{mention}', [SuperAdminController::class, 'updateMention'])->name('superadmin.mentions.update');
    Route::delete('/superadmin/mentions/{mention}', [SuperAdminController::class, 'destroyMention'])->name('superadmin.mentions.destroy');
    Route::get('/superadmin/mentions/{mention}', [SuperAdminController::class, 'showMention'])->name('superadmin.mentions.show');
    // Gestion des étudiants
    Route::get('/superadmin/students', [SuperAdminController::class, 'studentsList'])->name('superadmin.students.list');
    Route::get('/superadmin/students/create', [SuperAdminController::class, 'createStudent'])->name('superadmin.students.create');
    Route::get('/superadmin/students/{student}', [SuperAdminController::class, 'showStudent'])->name('superadmin.students.show');
    Route::post('/superadmin/students', [SuperAdminController::class, 'storeStudent'])->name('superadmin.students.store');
    Route::get('/superadmin/students/{student}/edit', [SuperAdminController::class, 'editStudent'])->name('superadmin.students.edit');
    Route::put('/superadmin/students/{student}', [SuperAdminController::class, 'updateStudent'])->name('superadmin.students.update');
    Route::delete('/superadmin/students/{student}', [SuperAdminController::class, 'destroyStudent'])->name('superadmin.students.destroy');
    // Ajout d'un cours à un étudiant
    Route::get('/superadmin/students/{student}/add-course', [SuperAdminController::class, 'addCourseToStudent'])->name('superadmin.students.courses.add');
    Route::post('/superadmin/students/{student}/add-course', [SuperAdminController::class, 'storeCourseToStudent'])->name('superadmin.students.courses.store');
    Route::patch('/superadmin/students/{student}/courses/{course}/remove', [\App\Http\Controllers\SuperAdminController::class, 'removeCourseFromStudent'])->name('superadmin.students.courses.remove');
    // Historique des cours d'un étudiant
    Route::get('/superadmin/students/{student}/courses/history', [\App\Http\Controllers\SuperAdminController::class, 'showStudentCourses'])->name('superadmin.students.courses.history');
    // Paramètres globaux
    Route::get('/superadmin/settings', function () {
        return view('superadmin.settings');})->name('superadmin.settings');
   Route::put('/superadmin/settings', [SuperAdminController::class, 'updateSettings'])->name('superadmin.settings.update');
});

// Gestion des utilisateurs
Route::resource('users', UserController::class)->except(['edit', 'update', 'destroy']);
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Gestion des étudiants
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
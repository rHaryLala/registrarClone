<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\FinanceDetailController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\MultimediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Apply locale middleware to all web routes so app locale is set on every request
Route::middleware('setlocale')->group(function () {

// Page d'accueil
Route::view('/', 'welcome');

// Inscription étudiant
Route::post('/check-access-code', [StudentController::class, 'checkAccessCode'])->name('check.access.code');
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

    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->isDean()) {
        return redirect()->route('dean.dashboard');
    }
    
    if (auth()->user()->isAccountant()) {
        return redirect()->route('accountant.dashboard');
    }

    if (auth()->user()->isMultimedia()) {
        return redirect()->route('multimedia.dashboard');
    }

    if (auth()->user()->isChiefAccountant()) {
        return redirect()->route('chief.accountant.dashboard');
    }
})->name('dashboard');

// API pour charger les parcours d'une mention (AJAX)
Route::get('/parcours/by-mention/{mentionId}', [ParcoursController::class, 'getByMention']);

// Dashboard SuperAdmin
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    
    // Gestion des cours
    Route::prefix('superadmin/courses')->name('superadmin.courses.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'coursesList'])->name('list');
        Route::get('/{course}/export-students', [SuperAdminController::class, 'exportCourseStudents'])->name('export');
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
        // AJAX endpoint: recompute a student's semester fee and return the record (before/after)
        Route::post('/{student}/recompute-semester-fee', [\App\Http\Controllers\SuperAdminController::class, 'recomputeStudentSemesterFee'])->name('recomputeSemesterFee');
    });
   
    // Paramètres globaux
    Route::get('/superadmin/settings', function () {
        return view('superadmin.settings');})->name('superadmin.settings');
    Route::put('/superadmin/settings', [SuperAdminController::class, 'updateSettings'])->name('superadmin.settings.update');


    // Gestion des finances étudiantes
    Route::prefix('superadmin/finances')->name('superadmin.finances.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'financesList'])->name('list');
        // AJAX update plan (A..E)
        Route::patch('/{finance}/plan', [SuperAdminController::class, 'updateFinancePlan'])->name('updatePlan');
        Route::get('/create', [SuperAdminController::class, 'createFinance'])->name('create');
        Route::post('/', [SuperAdminController::class, 'storeFinance'])->name('store');
        Route::get('/{finance}/edit', [SuperAdminController::class, 'editFinance'])->name('edit');
        Route::put('/{finance}', [SuperAdminController::class, 'updateFinance'])->name('update');
        Route::delete('/{finance}', [SuperAdminController::class, 'destroyFinance'])->name('destroy');
    });

    // Gestion des détails de finances
    Route::prefix('superadmin/financedetails')->name('superadmin.financedetails.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('index');
        Route::get('/create', [SuperAdminController::class, 'create'])->name('create');
        Route::post('/', [SuperAdminController::class, 'store'])->name('store');
        Route::get('/{detail}/edit', [SuperAdminController::class, 'edit'])->name('edit');
        Route::put('/{detail}', [SuperAdminController::class, 'update'])->name('update');
        Route::delete('/{detail}', [SuperAdminController::class, 'destroy'])->name('destroy');
        Route::get('/{detail}', [SuperAdminController::class, 'show'])->name('show');
    });

    // Route pour générer le PDF récapitulatif de l'inscription d'un étudiant
    Route::get('/recap/{id}/pdf', [SuperAdminController::class, 'exportStudentPdf'])->name('recap.pdf');
    
});


// Dean routes  
Route::middleware(['auth', 'dean'])->prefix('dean')->name('dean.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DeanController::class, 'dashboard'])->name('dashboard');
    
    // Student management
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [DeanController::class, 'studentsList'])->name('index');
        Route::get('/{id}', [DeanController::class, 'showStudent'])->name('show');
        Route::get('/{id}/courses', [DeanController::class, 'studentCourses'])->name('courses');
        Route::get('/{id}/courses/history', [DeanController::class, 'showStudentCourses'])->name('courses.history');
        Route::get('/{id}/add-course', [DeanController::class, 'addCourseToStudent'])->name('courses.add');
        Route::post('/{id}/add-course', [DeanController::class, 'storeCourseToStudent'])->name('courses.store');
        Route::patch('/{id}/courses/{courseId}/remove', [DeanController::class, 'removeCourseFromStudent'])->name('courses.remove');
    });
    
    // Teacher management
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [DeanController::class, 'teachersList'])->name('list');
        Route::get('/{id}', [DeanController::class, 'showTeacher'])->name('show');
        Route::get('/create', [DeanController::class, 'createTeacher'])->name('create');
        Route::post('/', [DeanController::class, 'storeTeacher'])->name('store');
    });

    // Payments: choose payment mode and generate installments
    Route::post('/students/{id}/payment-mode', [PaymentController::class, 'choosePaymentMode'])->name('students.payment.choose');
    
    // Course management  
    Route::prefix('courses')->name('courses.')->group(function () {
        // Export students enrolled in a course (CSV)
        Route::get('/{id}/export-students', [DeanController::class, 'exportStudents'])->name('export');
        Route::get('/', [DeanController::class, 'coursesList'])->name('list');
        Route::get('/create', [DeanController::class, 'createCourse'])->name('create');
        Route::post('/', [DeanController::class, 'storeCourse'])->name('store');
        Route::get('/{id}', [DeanController::class, 'showCourse'])->name('show');
        Route::get('/{id}/edit', [DeanController::class, 'editCourse'])->name('edit');
        Route::put('/{id}', [DeanController::class, 'updateCourse'])->name('update');
    });
    
    // Settings
    Route::get('/settings', [DeanController::class, 'settings'])->name('settings');
    Route::put('/settings', [DeanController::class, 'updateSettings'])->name('settings.update');
});

// Accountant routes
Route::middleware(['auth', 'accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    Route::get('/dashboard', [AccountantController::class, 'dashboard'])->name('dashboard');
    Route::patch('/students/{student}/fee-check', [AccountantController::class, 'updateFeeCheck'])->name('students.fee_check');
});

// Chief accountant routes (separate role)
Route::middleware(['auth', 'chief.accountant'])->prefix('chief-accountant')->name('chief.accountant.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\ChiefAccountantController::class, 'dashboard'])->name('dashboard');
});

// Multimedia routes
Route::middleware(['auth', 'multimedia'])->prefix('multimedia')->name('multimedia.')->group(function () {
    Route::get('/dashboard', [MultimediaController::class, 'dashboard'])->name('dashboard');
    // Student routes for multimedia
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/{student}', [MultimediaController::class, 'show'])->name('show');
        Route::put('/{student}', [MultimediaController::class, 'update'])->name('update');
    });
});

// Gestion des utilisateurs
Route::resource('users', UserController::class)->except(['edit', 'update', 'destroy']);
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Gestion des étudiants
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// Routes pour le doyen


// Preview endpoints for export content - accessible only to superadmin
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/preview', [SuperAdminController::class, 'previewIndex']);
    Route::get('/preview/content', [SuperAdminController::class, 'previewContent']);
});

});


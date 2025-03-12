<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SigaSifController; // Necesitarás crear este controlador


Route::get('/', function () {
    return view('welcome');
});


// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para todos los usuarios autenticados
Route::middleware('auth')->group(function () {
    // Dashboard general del usuario
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gestión de usuarios
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('admin.users.index');
});

// Rutas para usuarios con permisos específicos
Route::middleware(['auth', 'permission:manage-users'])->group(function () {
    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create');

    Route::post('/users', function () {
        // Lógica para crear usuarios
        return redirect()->route('admin.users.index');
    })->name('users.store');
});

// Rutas accesibles a múltiples roles
Route::middleware(['auth', 'role:admin,manager,editor'])->group(function () {
    Route::get('/content', function () {
        return view('content.index');
    })->name('content.index');
});

// Rutas para el módulo SIGA SIF
Route::middleware(['auth', 'permission:view-catalogo-siga'])->prefix('siga')->group(function () {
    // Ruta principal del catálogo
    Route::get('/catalogo', [SigaSifController::class, 'catalogoIndex'])->name('siga.catalogo.index');

    // Rutas protegidas por permisos específicos
    Route::middleware(['permission:update-bienes-siga'])->group(function () {
        Route::get('/bienes/update', [SigaSifController::class, 'bienesUpdateForm'])->name('siga.bienes.update');
        Route::post('/bienes/update', [SigaSifController::class, 'bienesUpdate'])->name('siga.bienes.update.post');
        // Nueva ruta para actualizar estados desde modal
        Route::put('/bienes/{id}/update-estados', [SigaSifController::class, 'updateEstados'])
            ->name('siga.bienes.update.estados');
    });

    Route::middleware(['permission:modify-catalogo-siga'])->group(function () {
        Route::get('/catalogo/modify', [SigaSifController::class, 'catalogoModifyForm'])->name('siga.catalogo.modify');
        Route::post('/catalogo/modify', [SigaSifController::class, 'catalogoModify'])->name('siga.catalogo.modify.post');
    });

    Route::middleware(['permission:manage-unidades-siga'])->group(function () {
        Route::get('/unidades', [SigaSifController::class, 'unidadesIndex'])->name('siga.unidades.index');
        Route::get('/unidades/create', [SigaSifController::class, 'unidadesCreate'])->name('siga.unidades.create');
        Route::post('/unidades', [SigaSifController::class, 'unidadesStore'])->name('siga.unidades.store');
        Route::get('/unidades/{id}/edit', [SigaSifController::class, 'unidadesEdit'])->name('siga.unidades.edit');
        Route::put('/unidades/{id}', [SigaSifController::class, 'unidadesUpdate'])->name('siga.unidades.update');
        Route::delete('/unidades/{id}', [SigaSifController::class, 'unidadesDestroy'])->name('siga.unidades.destroy');
    });

    // Ruta para administración completa de SIGA
    Route::middleware(['permission:admin-siga-complete'])->group(function () {
        Route::get('/admin', [SigaSifController::class, 'adminPanel'])->name('siga.admin');
    });
});

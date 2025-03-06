<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

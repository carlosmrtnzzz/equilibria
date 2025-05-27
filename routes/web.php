<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PreferenceController;
use App\Http\Middleware\CheckStreak;
use App\Http\Middleware\RequireRegistration;

// Home
Route::get('/', function () {
    return view('home');
})->name('/');

// Registro y login
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Formulario de datos del usuario (segunda parte del registro)
Route::get('/datos', function () {
    if (!session()->has('register_email')) {
        return redirect()->route('register')->with('message', 'Primero completa el formulario de registro.');
    }
    return view('user_info_form');
})->name('datos.usuario');

Route::post('/datos', [UserDataController::class, 'guardarDatos'])->name('guardar.datos');

// Rutas protegidas (RequireRegistration)
Route::middleware(RequireRegistration::class)->group(function () {

    Route::get('/chat', function () {
        return view('pages.chat');
    })->name('chat');

    Route::get('/logros', function () {
        return view('pages.logros');
    })->name('logros');

    Route::get('/perfil', function () {
        return view('perfil');
    })->middleware(CheckStreak::class)->name('perfil');

    Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])->middleware(CheckStreak::class);
    Route::post('/plan/generar', [PlanController::class, 'generar'])->middleware(CheckStreak::class)->name('plan.generar');
    Route::post('/plan/reemplazar-platos', [PlanController::class, 'reemplazarPlatos'])->middleware(CheckStreak::class);

    Route::get('/planes', [PlanController::class, 'index'])->name('planes');
    Route::get('/chat/historial', [ChatController::class, 'historial'])->middleware(CheckStreak::class);
    Route::get('/chat/plan-actual', [PlanController::class, 'planActual'])->middleware(CheckStreak::class);

    Route::put('/perfil/actualizar', [UserDataController::class, 'actualizar'])->name('perfil.actualizar');

    Route::get('/logros', function () {
        return app(PerfilController::class)->indexLogros();
    })->name('logros');

    Route::get('/preferences', [PreferenceController::class, 'fetch']);
    Route::post('/preferences', [PreferenceController::class, 'update']);
});

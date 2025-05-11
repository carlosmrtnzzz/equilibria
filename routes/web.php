<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PlanController;

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

// Rutas protegidas (solo accesibles si el usuario está registrado o en proceso)
Route::get('/chat', function () {
    if (!auth()->check() && !session()->has('register_email')) {
        return redirect()->route('register')->with('message', 'Debes registrarte para acceder al chat.');
    }
    return view('pages.chat');
})->name('chat');

Route::get('/planes', function () {
    if (!auth()->check() && !session()->has('register_email')) {
        return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes.');
    }
    return view('pages.planes');
})->name('planes');

Route::get('/logros', function () {
    if (!auth()->check() && !session()->has('register_email')) {
        return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los logros.');
    }
    return view('pages.logros');
})->name('logros');

// Perfil (solo para usuarios ya autenticados)
Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth')->name('perfil');

Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])->middleware('auth');

Route::post('/plan/generar', [PlanController::class, 'generar'])->middleware('auth')->name('plan.generar');

Route::get('/planes', [PlanController::class, 'index'])->middleware('auth')->name('planes');
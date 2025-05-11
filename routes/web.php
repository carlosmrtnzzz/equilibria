<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDataController;

Route::get('/', function () {
    return view('home');
})->name('/');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/datos', function () {
    return view('user_info_form');
})->middleware('auth')->name('datos.usuario');

Route::post('/datos', [UserDataController::class, 'guardarDatos'])->name('guardar.datos');

Route::get('/chat', function () {
    if (!Auth::check()) {
        return redirect()->route('register')->with('message', 'Debes registrarte para acceder al chat.');
    }
    return view('chat');
})->name('chat');

Route::get('/planes', function () {
    if (!Auth::check()) {
        return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes semanales.');
    }
    return view('planes');
})->name('planes');

Route::get('/perfil', fn() => view('perfil'))->name('perfil');

Route::get('/datos', function () {
    if (!session()->has('register_email')) {
        return redirect()->route('register')->with('message', 'Primero completa el formulario de registro.');
    }
    return view('user_info_form');
})->name('datos.usuario');

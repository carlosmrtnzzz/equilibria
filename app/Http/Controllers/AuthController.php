<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('login.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Guardamos los datos en sesión (no en DB)
        session([
            'register_name' => $request->name,
            'register_email' => $request->email,
            'register_password' => bcrypt($request->password),
        ]);

        return redirect()->route('datos.usuario');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // ¿Ya existe el usuario?
        $user = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

        if ($user) {
            // Si ya existe y tiene los datos completos, loguea y redirige
            Auth::login($user);
            return redirect()->route('perfil');
        }

        // Si NO existe, guarda los datos en sesión y redirige a /datos
        session([
            'register_email' => $googleUser->getEmail(),
            'register_name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            // Puedes guardar más datos si quieres
        ]);

        return redirect()->route('datos.usuario');
    }
}

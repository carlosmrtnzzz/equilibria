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
        $request->validate([
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'regex:/[A-Z]/',      // Al menos una mayúscula
                'regex:/[a-z]/',      // Al menos una minúscula
                'regex:/[0-9]/',      // Al menos un número
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/',

            ],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña debe cumplir todos los requisitos.',
            'password.min' => ' ',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas.',
        ])->withInput($request->only('email'));
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
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/',
            ],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe cumplir todos los requisitos.',
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
        ]);

        return redirect()->route('datos.usuario');
    }
}

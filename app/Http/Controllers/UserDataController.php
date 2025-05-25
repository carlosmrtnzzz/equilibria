<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDataController extends Controller
{
    public function guardarDatos(Request $request)
    {
        $request->validate([
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:30',
        ]);

        $name = session('register_name');
        $email = session('register_email');
        $password = session('register_password');

        if (!$name || !$email || !$password) {
            return redirect()->route('register')->with('message', 'Sesión expirada. Regístrate de nuevo.');
        }

        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'age' => Carbon::parse($request->birth_date)->age,
            'gender' => $request->gender,
            'weight_kg' => $request->weight,
            'height_cm' => $request->height,
        ]);

        session()->forget(['register_name', 'register_email', 'register_password']);
        Auth::login($user);
        return redirect('/')->with('success', 'Cuenta creada correctamente.');

    }
    public function actualizar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|numeric|min:1',
            'gender' => 'in:male,female',
            'weight_kg' => 'nullable|numeric|min:1',
            'height_cm' => 'nullable|numeric|min:1',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'weight_kg' => $request->input('weight_kg'),
            'height_cm' => $request->input('height_cm'),
        ]);

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
}

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
            'height_cm' => $request->height,
            'weight_kg' => $request->weight,
            'gender' => $request->gender,
        ]);
    
        session()->forget(['register_name', 'register_email', 'register_password']);
    
        Auth::login($user);
    
        return redirect('/')->with('success', 'Cuenta creada correctamente.');
    }
    
    
}

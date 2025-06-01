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
        $google_id = session('google_id');

        if (!$name || !$email || (!$password && !$google_id)) {
            return redirect()->route('register')->with('message', 'Sesión expirada. Regístrate de nuevo.');
        }

        // Evita duplicados por email o google_id
        $user = \App\Models\User::when($email, fn($query) => $query->where('email', $email))
            ->when($google_id, fn($query) => $query->orWhere('google_id', $google_id))
            ->first();


        if ($user) {
            Auth::login($user);
            session()->forget(['register_name', 'register_email', 'register_password', 'google_id']);

            // Redirige dependiendo del tipo de usuario
            return redirect($user->is_admin ? '/admin' : 'perfil')
                ->with('info', 'Ya tenías cuenta, has iniciado sesión.');
        }

        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password ?? bcrypt(uniqid()),
            'google_id' => $google_id,
            'age' => Carbon::parse($request->birth_date)->age,
            'gender' => $request->gender,
            'weight_kg' => $request->weight,
            'height_cm' => $request->height,
            'is_admin' => false,
        ]);

        session()->forget(['register_name', 'register_email', 'register_password', 'google_id']);
        Auth::login($user);
        return redirect('perfil')->with('success', 'Bienvenido, a Equilibria ' . explode(' ', $user->name)[0] . '!');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $request->validate([
                'profile_photo' => 'image|max:1024',
            ]);
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['profile_photo' => $path]);
            }
            return redirect()->route('perfil')->with('success', 'Foto de perfil actualizada.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|numeric|min:1',
            'gender' => 'in:male,female',
            'weight_kg' => 'nullable|numeric|min:1',
            'height_cm' => 'nullable|numeric|min:1',
        ]);

        $user->update([
            'name' => ucwords(strtolower($request->input('name'))),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'weight_kg' => $request->input('weight_kg'),
            'height_cm' => $request->input('height_cm'),
        ]);

        if ($request->wantsJson()) {
            return response()->json($user);
        }

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}

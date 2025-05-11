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
    
        $user = Auth::user();
        $user->age = Carbon::parse($request->birth_date)->age;
        $user->gender = $request->gender;
        $user->weight_kg = $request->weight;
        $user->height_cm = $request->height;
        $user->save();
    
        return redirect('/')->with('success', 'Datos guardados correctamente.');
    }
    
}

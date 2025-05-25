<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Preference;

class PreferenceController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'is_celiac' => 'boolean',
            'is_lactose_intolerant' => 'boolean',
            'is_fructose_intolerant' => 'boolean',
            'is_histamine_intolerant' => 'boolean',
            'is_sorbitol_intolerant' => 'boolean',
            'is_casein_intolerant' => 'boolean',
            'is_egg_intolerant' => 'boolean',
        ]);

        $preference = Preference::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return response()->json(['success' => true]);
    }


    public function fetch()
    {
        $user = Auth::user();
        return response()->json($user->preference);
    }
}

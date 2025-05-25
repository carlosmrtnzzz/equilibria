<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;

class PerfilController extends Controller
{
    public function indexLogros()
    {
        $user = Auth::user();

        $allAchievements = Achievement::with([
            'users' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }
        ])->get();

        return view('pages.logros', compact('allAchievements'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Achievement;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function indexLogros()
    {
        $user = Auth::user();

        $allAchievements = Achievement::all()->map(function ($achievement) use ($user) {
            $achievement->setRelation(
                'users',
                $achievement->users()->where('user_id', $user->id)->get()
            );
            return $achievement;
        });

        return view('pages.logros', compact('allAchievements'));
    }
}

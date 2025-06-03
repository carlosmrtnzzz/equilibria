<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Achievement;
use App\Models\UserAchievement;

class CheckStreak
{
    public function handle(Request $request, Closure $next = null)
    {
        $user = Auth::user();
        $hoy = Carbon::now()->startOfDay();
        $ayer = Carbon::yesterday()->startOfDay();

        $actualizarStreak = false;

        if (!$user->last_login_date || $user->last_login_date < $hoy->toDateString()) {
            if ($user->last_login_date == $ayer->toDateString()) {
                $user->streak_days++;
            } else {
                $user->streak_days = 1;
            }
            $user->last_login_date = $hoy->toDateString();
            $user->save();
        }

        $logros = Achievement::where('type', 'login_streak')->get();

        foreach ($logros as $logro) {
            $userLogro = UserAchievement::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'achievement_id' => $logro->id,
                ],
                [
                    'progress' => 0,
                    'unlocked' => false,
                ]
            );

            $userLogro->progress = $user->streak_days;

            if (!$userLogro->unlocked && $user->streak_days >= $logro->target_value) {
                $userLogro->unlocked = true;
                $userLogro->unlocked_at = now();

                session()->flash('success', '¡Has desbloqueado el logro: ' . $logro->name . '!');
            }

            $userLogro->save();
        }

        return $next ? $next($request) : null;
    }

}

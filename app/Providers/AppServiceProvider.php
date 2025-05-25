<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckStreak;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!Storage::disk('public')->exists('planes')) {
            try {
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                \Log::error('No se pudo crear el enlace de storage: ' . $e->getMessage());
            }
        }
        app()->booted(function () {
            if (Auth::check()) {
                app(CheckStreak::class)->handle(request(), fn() => null);
            }
        });
    }
}

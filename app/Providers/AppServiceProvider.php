<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckStreak;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, CustomLogoutResponse::class);

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

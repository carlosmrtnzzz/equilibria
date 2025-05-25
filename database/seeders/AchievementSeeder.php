<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Primer plan generado',
                'description' => 'Has generado tu primer plan semanal.',
                'type' => 'generate_plan',
                'target_value' => 1,
                'reward_type' => 'extra_swap',
                'reward_amount' => 1,
                'icon' => 'plan1.png',
            ],
            [
                'name' => 'Racha de 3 días',
                'description' => 'Has iniciado sesión 3 días seguidos.',
                'type' => 'login_streak',
                'target_value' => 3,
                'reward_type' => 'extra_swap',
                'reward_amount' => 1,
                'icon' => 'streak3.png',
            ],
            [
                'name' => 'Racha de 7 días',
                'description' => 'Has iniciado sesión durante 7 días seguidos.',
                'type' => 'login_streak',
                'target_value' => 7,
                'reward_type' => 'extra_regeneration',
                'reward_amount' => 1,
                'icon' => 'streak7.png',
            ],
            [
                'name' => 'Primer cambio de plato',
                'description' => 'Has cambiado un plato por primera vez.',
                'type' => 'change_dish',
                'target_value' => 1,
                'reward_type' => 'extra_swap',
                'reward_amount' => 1,
                'icon' => 'dish1.png',
            ],
            [
                'name' => 'Perfil completo',
                'description' => 'Has completado todos los datos de tu perfil.',
                'type' => 'complete_profile',
                'target_value' => 1,
                'reward_type' => 'extra_swap',
                'reward_amount' => 1,
                'icon' => 'profile.png',
            ],
        ];

        foreach ($achievements as $data) {
            Achievement::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}

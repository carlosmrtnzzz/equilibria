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
                'reward_amount' => 1
            ],

            // Cambiar platos
            [
                'name' => 'Primer cambio de plato',
                'description' => 'Has reemplazado un plato en tu plan semanal.',
                'type' => 'change_dish',
                'target_value' => 1,
                'reward_type' => 'extra_swap',
                'reward_amount' => 1
            ],
            [
                'name' => 'Maestro del reemplazo',
                'description' => 'Has reemplazado 20 platos en total.',
                'type' => 'change_dish',
                'target_value' => 20,
                'reward_type' => 'extra_swap',
                'reward_amount' => 3
            ],

            // Rachas de login
            [
                'name' => 'Racha de 3 días',
                'description' => 'Has accedido a Equilibria durante 3 días seguidos.',
                'type' => 'login_streak',
                'target_value' => 3,
                'reward_type' => 'extra_regeneration',
                'reward_amount' => 1
            ],
            [
                'name' => 'Racha de 7 días',
                'description' => 'Has accedido a Equilibria durante 7 días seguidos.',
                'type' => 'login_streak',
                'target_value' => 7,
                'reward_type' => 'extra_regeneration',
                'reward_amount' => 2
            ],
            [
                'name' => 'Racha de 30 días',
                'description' => 'Has accedido a Equilibria durante 30 días seguidos.',
                'type' => 'login_streak',
                'target_value' => 30,
                'reward_type' => 'extra_regeneration',
                'reward_amount' => 5
            ]
        ];

        foreach ($achievements as $data) {
            Achievement::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}

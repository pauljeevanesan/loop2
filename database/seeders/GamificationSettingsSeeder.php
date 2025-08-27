<?php

namespace Database\Seeders;

use App\Models\GamificationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'action_name' => 'complete_lesson',
                'display_name' => 'Complete a Lesson',
                'points' => 5,
                'is_active' => true,
            ],
            [
                'action_name' => 'pass_quiz',
                'display_name' => 'Pass a Chapter Quiz',
                'points' => 25,
                'is_active' => true,
            ],
            [
                'action_name' => 'complete_course',
                'display_name' => 'Complete a Course',
                'points' => 100,
                'is_active' => true,
            ],
            [
                'action_name' => 'points_to_currency_rate',
                'display_name' => 'Points per $1 USD',
                'points' => 100, // Default value: 100 points = $1
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            GamificationSetting::updateOrCreate(
                ['action_name' => $setting['action_name']],
                $setting
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
        ]);

        // Seed Slots
        $startTime = strtotime('09:00');
        $endTime = strtotime('18:00');
        $interval = 30 * 60; // 30 minutes in seconds

        $slots = [];
        while ($startTime < $endTime) {
            $nextTime = $startTime + $interval;
            $slots[] = [
                'start_time' => date('H:i', $startTime),
                'end_time' => date('H:i', $nextTime),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $startTime = $nextTime;
        }

        DB::table('slots')->insert($slots);
    }
}

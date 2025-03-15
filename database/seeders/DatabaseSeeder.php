<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'pi']);
        Role::create(['name' => 'student']);

        // Run Permission Seeder
        $this->call(PermissionSeeder::class);

        // Seed Users
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
        ]);

        // Assign super_admin role to the user
        $user->assignRole('super_admin');

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

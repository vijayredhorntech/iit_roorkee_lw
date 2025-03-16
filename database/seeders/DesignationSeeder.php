<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $designations = [
            ['title' => 'Professor'],
            ['title' => 'Associate Professor'],
            ['title' => 'Assistant Professor'],
            ['title' => 'Senior Lecturer'],
            ['title' => 'Lecturer'],
            ['title' => 'Research Professor'],
            ['title' => 'Visiting Professor'],
            ['title' => 'Adjunct Professor'],
            ['title' => 'Professor Emeritus'],
            ['title' => 'Research Associate']
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
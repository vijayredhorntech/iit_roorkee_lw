<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['title' => 'Chemistry'],
            ['title' => 'Physics'],
            ['title' => 'Mathematics'],
            ['title' => 'Computer Science'],
            ['title' => 'Mechanical Engineering'],
            ['title' => 'Electrical Engineering'],
            ['title' => 'Civil Engineering'],
            ['title' => 'Biotechnology'],
            ['title' => 'Chemical Engineering'],
            ['title' => 'Electronics and Communication'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
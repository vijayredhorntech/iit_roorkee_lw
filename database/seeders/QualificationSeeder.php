<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    public function run(): void
    {
        $qualifications = [
            ['title' => 'B.Sc.'],
            ['title' => 'M.Sc.'],
            ['title' => 'Ph.D.'],
            ['title' => 'B.Tech.'],
            ['title' => 'M.Tech.'],
            ['title' => 'B.E.'],
            ['title' => 'M.E.'],
            ['title' => 'MCA'],
            ['title' => 'BCA'],
            ['title' => 'Post Doctorate']
        ];

        foreach ($qualifications as $qualification) {
            Qualification::create($qualification);
        }
    }
}
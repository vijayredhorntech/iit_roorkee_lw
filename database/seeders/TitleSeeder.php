<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            ['title' => 'Dr.'],
            ['title' => 'Prof.'],
            ['title' => 'Assoc. Prof.'],
            ['title' => 'Asst. Prof.'],
            ['title' => 'Mr.'],
            ['title' => 'Mrs.'],
            ['title' => 'Ms.'],
        ];

        foreach ($titles as $title) {
            Title::create($title);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Setting::factory()->create(
            [
                'name' => 'module',
                'value' => 'higalaay',
                'description' => 'higalaay festival'
            ]
        );

        $categories = [
            ['category' => 'band', 'is_active' => 1, 'description' => 'Marching Band', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'float', 'is_active' => 1, 'description' => 'Float Competition', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'majorette', 'is_active' => 1, 'description' => 'Best Band Majorette', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'major', 'is_active' => 1, 'description' => 'Best Band Major', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'costume', 'is_active' => 1, 'description' => 'Best in Costume', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'oral', 'is_active' => 0, 'description' => 'Oratorical', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'poster', 'is_active' => 0, 'description' => 'Poster Making Contest', 'icon' => '<i class="bi bi-box-seam"></i>'],
            ['category' => 'quiz', 'is_active' => 0, 'description' => 'Quiz Bee', 'icon' => '<i class="bi bi-box-seam"></i>'],
        ];

        foreach ($categories as $category) {
            Category::factory()->create($category);
        }
    }
}

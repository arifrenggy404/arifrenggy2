<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Arif Renggy',
                'password' => Hash::make('password'),
            ]
        );

        // Create Profile
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'tagline' => 'IT Student & Fullstack Developer',
                'bio' => 'Saya adalah mahasiswa IT dengan minat mendalam pada Laravel, backend development, dan desain website minimalis elegan.',
                'socials' => [
                    'github' => 'https://github.com',
                    'linkedin' => 'https://linkedin.com',
                    'email' => 'arif@example.com'
                ]
            ]
        );

        // Create Skills
        Skill::updateOrCreate(['name' => 'Laravel'], ['category' => 'backend', 'order' => 1]);
        Skill::updateOrCreate(['name' => 'PHP'], ['category' => 'backend', 'order' => 2]);
        Skill::updateOrCreate(['name' => 'MySQL'], ['category' => 'backend', 'order' => 3]);
        Skill::updateOrCreate(['name' => 'CSS3'], ['category' => 'frontend', 'order' => 4]);
        Skill::updateOrCreate(['name' => 'Alpine.js'], ['category' => 'frontend', 'order' => 5]);
        Skill::updateOrCreate(['name' => 'Git'], ['category' => 'tools', 'order' => 6]);

        // Create Sample Project
        Project::updateOrCreate(
            ['slug' => 'portfolio-laravel'],
            [
                'title' => 'Personal Portfolio Laravel',
                'summary' => 'Website portofolio minimalis modern ini dibangun dengan Laravel 13 dan Filament v5.',
                'desc_content' => '<p>Ini adalah deskripsi utama dari proyek ini. Menggunakan arsitektur monolitik yang tangguh dan ringan.</p>',
                'arch_content' => '<p>Arsitektur menggunakan Laravel Blade, SQLite, dan Alpine.js untuk performa maksimal.</p>',
                'code_content' => '<pre><code>public function index() {\n    return view("home");\n}</code></pre>',
                'is_featured' => true,
                'order' => 1
            ]
        );
    }
}

# Personal Portfolio Website Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a modern, minimalist Laravel 13 portfolio website with a Filament v3 admin panel and a customized Blade+Vanilla CSS frontend featuring a Bento Grid layout on the homepage and a Tabbed Showcase on the project details.

**Architecture:** SQLite database with tables for Profile, Skill, Project, and Message; Filament v3 resources for CRUD management; custom frontend Blade templates styled with elegant Vanilla CSS.

**Tech Stack:** Laravel 13, PHP 8.4, Filament v3, Livewire, SQLite, Vanilla CSS, Alpine.js (reused from Livewire/Filament layout or inline).

## Global Constraints
- SQLite as database, Laravel 13 framework.
- Dual-mode (Light/Dark) toggle with LocalStorage persistence.
- Clean, modern layout (Bento Grid home, Tabbed Showcase detail, Contact inbox).
- Write tests for database schemas and controller routing.

---

### Task 1: Project Scaffolding & SQLite Setup

**Files:**
- Create: `database/database.sqlite`
- Modify: `.env`
- Modify: `config/database.php`

**Interfaces:**
- Consumes: None
- Produces: A running Laravel 13 application configured with SQLite.

- [ ] **Step 1: Scaffold Laravel 13 project**

Run:
```bash
composer create-project laravel/laravel:^13.0 . --prefer-dist
```
Expected: Files scaffolded in `/root/arifrenggy2` successfully.

- [ ] **Step 2: Create SQLite Database File**

Run:
```bash
touch database/database.sqlite
```

- [ ] **Step 3: Update `.env` Configuration**

Modify `.env` to configure the SQLite database connection.
Target content in `.env`:
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
Replacement content in `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/root/arifrenggy2/database/database.sqlite
```

- [ ] **Step 4: Run Initial Migrations to Verify SQLite Connection**

Run:
```bash
php artisan migrate
```
Expected: Standard Laravel tables (users, password_reset_tokens, sessions, jobs) are successfully migrated to SQLite database.

- [ ] **Step 5: Commit**

Run:
```bash
git add .
git commit -m "chore: scaffold laravel 11 project and configure sqlite database"
```

---

### Task 2: Database Schema & Models (`Profile`, `Skill`, `Project`, `Message`)

**Files:**
- Create: `database/migrations/2026_06_20_000001_create_profiles_table.php`
- Create: `database/migrations/2026_06_20_000002_create_skills_table.php`
- Create: `database/migrations/2026_06_20_000003_create_projects_table.php`
- Create: `database/migrations/2026_06_20_000004_create_messages_table.php`
- Create: `app/Models/Profile.php`
- Create: `app/Models/Skill.php`
- Create: `app/Models/Project.php`
- Create: `app/Models/Message.php`
- Create: `tests/Feature/DatabaseSchemaTest.php`

**Interfaces:**
- Consumes: Database connection from Task 1.
- Produces: `Profile`, `Skill`, `Project`, and `Message` models and tables.

- [ ] **Step 1: Write Migration Files**

Create `database/migrations/2026_06_20_000001_create_profiles_table.php` with:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('avatar_path')->nullable();
            $table->string('tagline');
            $table->text('bio');
            $table->string('resume_path')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
```

Create `database/migrations/2026_06_20_000002_create_skills_table.php` with:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // frontend, backend, tools
            $table->text('icon_svg')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
```

Create `database/migrations/2026_06_20_000003_create_projects_table.php` with:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary');
            $table->text('desc_content');
            $table->text('arch_content')->nullable();
            $table->text('code_content')->nullable();
            $table->string('image_path')->nullable();
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
```

Create `database/migrations/2026_06_20_000004_create_messages_table.php` with:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
```

- [ ] **Step 2: Create Model Files**

Create `app/Models/Profile.php` with:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['avatar_path', 'tagline', 'bio', 'resume_path', 'socials'];
    protected $casts = [
        'socials' => 'array',
    ];
}
```

Create `app/Models/Skill.php` with:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'category', 'icon_svg', 'order'];
}
```

Create `app/Models/Project.php` with:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'summary', 'desc_content', 
        'arch_content', 'code_content', 'image_path', 
        'github_url', 'demo_url', 'is_featured', 'order'
    ];
}
```

Create `app/Models/Message.php` with:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['name', 'email', 'message'];
}
```

- [ ] **Step 3: Run Migrations**

Run:
```bash
php artisan migrate
```
Expected: Profile, Skill, Project, and Message tables migrated successfully.

- [ ] **Step 4: Write Database Schema Feature Test**

Create `tests/Feature/DatabaseSchemaTest.php` with:
```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Message;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_profile_record(): void
    {
        $profile = Profile::create([
            'tagline' => 'Fullstack Student',
            'bio' => 'Student at IT University',
            'socials' => ['github' => 'https://github.com/arifrenggy']
        ]);

        $this->assertDatabaseHas('profiles', [
            'tagline' => 'Fullstack Student'
        ]);
        $this->assertEquals('https://github.com/arifrenggy', $profile->socials['github']);
    }

    public function test_can_create_skill_record(): void
    {
        Skill::create([
            'name' => 'Laravel',
            'category' => 'backend',
            'order' => 1
        ]);

        $this->assertDatabaseHas('skills', [
            'name' => 'Laravel',
            'category' => 'backend'
        ]);
    }

    public function test_can_create_project_record(): void
    {
        Project::create([
            'title' => 'Project Alpha',
            'slug' => 'project-alpha',
            'summary' => 'Short summary',
            'desc_content' => 'Overview content',
            'is_featured' => true
        ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'Project Alpha',
            'slug' => 'project-alpha'
        ]);
    }

    public function test_can_create_message_record(): void
    {
        Message::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello there!'
        ]);

        $this->assertDatabaseHas('messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
    }
}
```

- [ ] **Step 5: Run Database Schema Test**

Run:
```bash
php artisan test --filter=DatabaseSchemaTest
```
Expected: 4 tests pass successfully.

- [ ] **Step 6: Commit**

Run:
```bash
git add .
git commit -m "feat: add profile, skill, project, message migrations, models and tests"
```

---

### Task 3: Install & Configure Filament PHP v3

**Files:**
- Create: `database/seeders/DatabaseSeeder.php`
- Modify: `composer.json`

**Interfaces:**
- Consumes: Schema from Task 2.
- Produces: Installed Filament v3 panels and database seed data.

- [ ] **Step 1: Install Filament Composer Dependencies**

Run:
```bash
composer require filament/filament:"^3.2" -W
```
Expected: Filament packages installed successfully.

- [ ] **Step 2: Install Filament Panels**

Run:
```bash
php artisan filament:install --panels
```
When prompted for default configuration options, press enter to accept defaults.
Expected: `app/Providers/Filament/AdminPanelProvider.php` is created.

- [ ] **Step 3: Configure Initial Seed Data**

Replace `database/seeders/DatabaseSeeder.php` with:
```php
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
                'summary' => 'Website portofolio minimalis modern ini dibangun dengan Laravel 11 dan Filament v3.',
                'desc_content' => '<p>Ini adalah deskripsi utama dari proyek ini. Menggunakan arsitektur monolitik yang tangguh dan ringan.</p>',
                'arch_content' => '<p>Arsitektur menggunakan Laravel Blade, SQLite, dan Alpine.js untuk performa maksimal.</p>',
                'code_content' => '<pre><code>public function index() {\n    return view("home");\n}</code></pre>',
                'is_featured' => true,
                'order' => 1
            ]
        );
    }
}
```

- [ ] **Step 4: Seed the Database**

Run:
```bash
php artisan db:seed
```
Expected: Database seeded with user, profile, skills, and projects.

- [ ] **Step 5: Verify Login Credentials**

We will write a test to verify that the admin user can authenticate.
Create `tests/Feature/AdminAuthTest.php` with:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_login(): void
    {
        $user = User::create([
            'name' => 'Arif',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/admin');
    }
}
```

Run:
```bash
php artisan test --filter=AdminAuthTest
```
Expected: Test passes successfully.

- [ ] **Step 6: Commit**

Run:
```bash
git add .
git commit -m "feat: install filament panels, setup database seeder, and add auth tests"
```

---

### Task 4: Implement Filament Resources (`Profile`, `Skill`, `Project`, `Message`)

**Files:**
- Create: `app/Filament/Resources/ProfileResource.php`
- Create: `app/Filament/Resources/SkillResource.php`
- Create: `app/Filament/Resources/ProjectResource.php`
- Create: `app/Filament/Resources/MessageResource.php`

**Interfaces:**
- Consumes: Models from Task 2, Filament Panel from Task 3.
- Produces: CRUD resources in the Filament admin panel.

- [ ] **Step 1: Generate Filament Resources**

Run:
```bash
php artisan make:filament-resource Profile --simple
php artisan make:filament-resource Skill
php artisan make:filament-resource Project
php artisan make:filament-resource Message
```
Expected: Filament Resource classes generated.

- [ ] **Step 2: Configure `ProfileResource`**

Edit `app/Filament/Resources/ProfileResource.php` with simple single-record form schema. Because we want a simple view, edit the `form` method:
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('tagline')->required(),
            Textarea::make('bio')->required(),
            FileUpload::make('avatar_path')->directory('profiles'),
            FileUpload::make('resume_path')->directory('resumes')->acceptedFileTypes(['application/pdf']),
            KeyValue::make('socials'),
        ]);
}
```

- [ ] **Step 3: Configure `SkillResource`**

Edit `app/Filament/Resources/SkillResource.php` form and table:
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')->required(),
            Select::make('category')
                ->options([
                    'frontend' => 'Frontend',
                    'backend' => 'Backend',
                    'tools' => 'Tools',
                ])->required(),
            Textarea::make('icon_svg')->rows(5),
            TextInput::make('order')->numeric()->default(0),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('category')->sortable(),
            TextColumn::make('order')->sortable(),
        ])
        ->defaultSort('order');
}
```

- [ ] **Step 4: Configure `ProjectResource`**

Edit `app/Filament/Resources/ProjectResource.php` form and table:
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                    $operation === 'create' ? $set('slug', Str::slug($state)) : null),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('summary')->required(),
            RichEditor::make('desc_content')->required()->label('Deskripsi Proyek (Tab 1)'),
            RichEditor::make('arch_content')->label('Arsitektur (Tab 2)'),
            RichEditor::make('code_content')->label('Cuplikan Kode (Tab 3)'),
            FileUpload::make('image_path')->directory('projects'),
            TextInput::make('github_url'),
            TextInput::make('demo_url'),
            Toggle::make('is_featured')->default(false),
            TextInput::make('order')->numeric()->default(0),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('title')->sortable()->searchable(),
            IconColumn::make('is_featured')->boolean()->sortable(),
            TextColumn::make('order')->sortable(),
        ])
        ->defaultSort('order');
}
```

- [ ] **Step 5: Configure `MessageResource`**

Edit `app/Filament/Resources/MessageResource.php` (Read-only view):
```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')->disabled(),
            TextInput::make('email')->disabled(),
            Textarea::make('message')->disabled(),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ]);
}
```

- [ ] **Step 6: Verify Admin panel Resources Load**

We will write a controller/integration test to verify admin pages load successfully.
Create `tests/Feature/AdminPanelResourcesTest.php` with:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPanelResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_resources(): void
    {
        $user = User::create([
            'name' => 'Arif',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $this->actingAs($user);

        // Load project resource page
        $response = $this->get('/admin/projects');
        $response->assertStatus(200);

        // Load skill resource page
        $response = $this->get('/admin/skills');
        $response->assertStatus(200);

        // Load message resource page
        $response = $this->get('/admin/messages');
        $response->assertStatus(200);
    }
}
```

Run:
```bash
php artisan test --filter=AdminPanelResourcesTest
```
Expected: All tests pass.

- [ ] **Step 7: Commit**

Run:
```bash
git add .
git commit -m "feat: configure profile, skill, project, and message filament resources with unit tests"
```

---

### Task 5: Frontend Layout & Theme Toggle (Bento Grid)

**Files:**
- Create: `app/Http/Controllers/PortfolioController.php`
- Create: `resources/views/layouts/app.blade.php`
- Create: `resources/views/index.blade.php`
- Create: `public/css/style.css`
- Modify: `routes/web.php`
- Create: `tests/Feature/FrontendRoutingTest.php`

**Interfaces:**
- Consumes: Database content from Task 2.
- Produces: Homepage visual output containing the custom CSS bento grid layout and the LocalStorage persistent Dark/Light toggle.

- [ ] **Step 1: Set Up Controller**

Create `app/Http/Controllers/PortfolioController.php` with:
```php
<?php

namespace App\Http/Controllers;

use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $skills = Skill::orderBy('order')->get();
        $featuredProjects = Project::where('is_featured', true)->orderBy('order')->get();

        return view('index', compact('profile', 'skills', 'featuredProjects'));
    }

    public function projects()
    {
        $projects = Project::orderBy('order')->get();
        return view('projects.index', compact('projects'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }

    public function contact()
    {
        return view('contact');
    }
}
```

- [ ] **Step 2: Configure Frontend Routes**

Replace `routes/web.php` with:
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Models\Message;
use Illuminate\Http\Request;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
Route::get('/projects/{slug}', [PortfolioController::class, 'show'])->name('projects.show');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    Message::create($validated);

    return back()->with('success', 'Pesan Anda berhasil terkirim!');
})->name('contact.store');
```

- [ ] **Step 3: Create Custom CSS Stylesheet**

Create `public/css/style.css` with dark/light themes, animations, bento grid layout:
```css
:root {
    --bg-primary: #fafafa;
    --bg-card: #ffffff;
    --text-primary: #09090b;
    --text-secondary: #71717a;
    --border: #e4e4e7;
    --accent: #4f46e5;
    --accent-hover: #4338ca;
}

[data-theme="dark"] {
    --bg-primary: #09090b;
    --bg-card: #18181b;
    --text-primary: #f4f4f5;
    --text-secondary: #a1a1aa;
    --border: #27272a;
    --accent: #6366f1;
    --accent-hover: #4f46e5;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Outfit', system-ui, -apple-system, sans-serif;
    line-height: 1.6;
    padding: 2rem 1rem;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
}

nav a {
    color: var(--text-secondary);
    text-decoration: none;
    margin-left: 1.5rem;
    font-weight: 500;
}

nav a:hover, nav a.active {
    color: var(--accent);
}

.theme-toggle-btn {
    background: none;
    border: 1px solid var(--border);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    cursor: pointer;
    font-size: 0.85rem;
}

/* Bento Grid */
.bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .bento-grid {
        grid-template-columns: 1fr;
    }
}

.bento-card {
    background-color: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.col-span-2 {
    grid-column: span 2;
}

@media (max-width: 768px) {
    .col-span-2 {
        grid-column: span 1;
    }
}

/* Buttons */
.btn {
    display: inline-block;
    background-color: var(--accent);
    color: #ffffff;
    padding: 0.75rem 1.5rem;
    border-radius: 9999px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 1rem;
    width: fit-content;
}

.btn:hover {
    background-color: var(--accent-hover);
}

.skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.skill-tag {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.85rem;
}
```

- [ ] **Step 4: Create Main Blade Layout**

Create `resources/views/layouts/app.blade.php` with:
```html
<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arif Renggy - Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        // Inline script to prevent flash of light theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="{{ route('home') }}" style="font-weight:700; font-size:1.25rem; color:var(--text-primary); text-decoration:none;">AR</a>
            </div>
            <nav style="display:flex; align-items:center;">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">Proyek</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
                <button class="theme-toggle-btn" id="themeToggle" style="margin-left: 1.5rem;">Mode</button>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        const btn = document.getElementById('themeToggle');
        btn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
        });
    </script>
</body>
</html>
```

- [ ] **Step 5: Create Home View (`index.blade.php`)**

Create `resources/views/index.blade.php` with:
```html
@extends('layouts.app')

@abstract
@section('content')
<div class="bento-grid">
    <!-- Hero Box -->
    <div class="bento-card col-span-2" style="min-height: 250px;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight:700; line-height:1.2;">Halo, Saya {{ $profile->tagline ?? 'Arif Renggy' }}</h1>
            <p style="margin-top: 1rem; color: var(--text-secondary);">Selamat datang di website portofolio pribadi saya.</p>
        </div>
        <div>
            @if(!empty($profile->resume_path))
                <a href="{{ asset('storage/' . $profile->resume_path) }}" class="btn" download>Unduh CV</a>
            @endif
        </div>
    </div>

    <!-- About Me -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600;">Tentang Saya</h2>
            <p style="margin-top: 1rem; color: var(--text-secondary); font-size: 0.95rem;">
                {{ $profile->bio ?? 'Saya adalah mahasiswa IT.' }}
            </p>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="bento-card col-span-2">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Proyek Unggulan</h2>
        <div style="display:flex; flex-direction:column; gap: 1rem;">
            @forelse($featuredProjects as $project)
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                    <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--text-primary); font-weight:600; font-size:1.1rem; text-decoration:none;">{{ $project->title }}</a>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:0.25rem;">{{ $project->summary }}</p>
                </div>
            @empty
                <p style="color:var(--text-secondary);">Belum ada proyek unggulan.</p>
            @endforelse
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="bento-card">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Teknologi</h2>
        <div class="skills-list">
            @forelse($skills as $skill)
                <span class="skill-tag">{{ $skill->name }}</span>
            @empty
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">Laravel</span>
            @endforelse
        </div>
    </div>
</div>
@endsection
```

- [ ] **Step 6: Write Frontend Routing Tests**

Create `tests/Feature/FrontendRoutingTest.php` with:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontendRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        Profile::create([
            'tagline' => 'IT Student',
            'bio' => 'IT Bio'
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('IT Student');
    }
}
```

Run:
```bash
php artisan test --filter=FrontendRoutingTest
```
Expected: Test passes successfully.

- [ ] **Step 7: Commit**

Run:
```bash
git add .
git commit -m "feat: implement frontend layout with CSS bento grid and dark/light toggle"
```

---

### Task 6: Project Details & Tabbed Showcase

**Files:**
- Create: `resources/views/projects/index.blade.php`
- Create: `resources/views/projects/show.blade.php`
- Create: `tests/Feature/ProjectDetailsTest.php`

**Interfaces:**
- Consumes: `Project` model and controller route from Task 5.
- Produces: Visual projects list page and interactive tab switcher on project details page.

- [ ] **Step 1: Create Projects List View**

Create `resources/views/projects/index.blade.php` with:
```html
@extends('layouts.app')

@section('content')
<h1 style="font-size: 2rem; font-weight:700; margin-bottom: 2rem;">Semua Proyek</h1>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($projects as $project)
        <div class="bento-card">
            <div>
                <h2 style="font-size:1.25rem; font-weight:600;">{{ $project->title }}</h2>
                <p style="margin-top: 0.5rem; color:var(--text-secondary); font-size: 0.9rem;">{{ $project->summary }}</p>
            </div>
            <div style="margin-top: 1.5rem; display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">Lihat Detail &rarr;</a>
            </div>
        </div>
    @empty
        <p style="color:var(--text-secondary);">Belum ada proyek yang ditambahkan.</p>
    @endforelse
</div>
@endsection
```

- [ ] **Step 2: Create Project Detail Tabbed Showcase View**

Create `resources/views/projects/show.blade.php` with:
```html
@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('projects.index') }}" style="color: var(--text-secondary); text-decoration:none; font-weight:500;">&larr; Kembali ke Proyek</a>
</div>

<div class="bento-card" style="padding: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight:700; margin-bottom: 0.5rem;">{{ $project->title }}</h1>
    <p style="color:var(--text-secondary); font-size:1.1rem; margin-bottom: 1.5rem;">{{ $project->summary }}</p>

    <div style="display:flex; gap: 1rem; margin-bottom: 2rem;">
        @if($project->github_url)
            <a href="{{ $project->github_url }}" class="btn" style="margin:0;" target="_blank">GitHub</a>
        @endif
        @if($project->demo_url)
            <a href="{{ $project->demo_url }}" class="btn" style="margin:0; background-color: var(--text-secondary);" target="_blank">Demo Live</a>
        @endif
    </div>

    <!-- Tabs Header -->
    <div style="display:flex; border-bottom: 1px solid var(--border); margin-bottom: 1.5rem; gap: 1.5rem;">
        <button class="tab-btn active" onclick="switchTab('deskripsi')" style="background:none; border:none; color:var(--accent); font-weight:600; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid var(--accent); cursor:pointer;">Deskripsi</button>
        <button class="tab-btn" onclick="switchTab('arsitektur')" style="background:none; border:none; color:var(--text-secondary); font-weight:500; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid transparent; cursor:pointer;">Arsitektur</button>
        <button class="tab-btn" onclick="switchTab('kode')" style="background:none; border:none; color:var(--text-secondary); font-weight:500; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid transparent; cursor:pointer;">Cuplikan Kode</button>
    </div>

    <!-- Tabs Content -->
    <div id="tab-deskripsi" class="tab-content" style="display:block;">
        {!! $project->desc_content !!}
    </div>
    <div id="tab-arsitektur" class="tab-content" style="display:none;">
        {!! $project->arch_content ?? '<p style="color:var(--text-secondary);">Tidak ada data arsitektur.</p>' !!}
    </div>
    <div id="tab-kode" class="tab-content" style="display:none;">
        {!! $project->code_content ?? '<p style="color:var(--text-secondary);">Tidak ada cuplikan kode.</p>' !!}
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        
        // Show selected tab content
        document.getElementById('tab-' + tabName).style.display = 'block';

        // Update tab buttons styles
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active');
            btn.style.color = 'var(--text-secondary)';
            btn.style.fontWeight = '500';
            btn.style.borderBottomColor = 'transparent';
        });

        // Set clicked button to active
        const clickedBtn = event.currentTarget;
        clickedBtn.classList.add('active');
        clickedBtn.style.color = 'var(--accent)';
        clickedBtn.style.fontWeight = '600';
        clickedBtn.style.borderBottomColor = 'var(--accent)';
    }
</script>
@endsection
```

- [ ] **Step 3: Write Project Detail Test**

Create `tests/Feature/ProjectDetailsTest.php` with:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_project_details(): void
    {
        $project = Project::create([
            'title' => 'Sample Project',
            'slug' => 'sample-project',
            'summary' => 'Sample summary',
            'desc_content' => '<p>Description text</p>',
            'arch_content' => '<p>Architecture text</p>'
        ]);

        $response = $this->get('/projects/sample-project');
        $response->assertStatus(200);
        $response->assertSee('Sample Project');
        $response->assertSee('Description text');
    }
}
```

Run:
```bash
php artisan test --filter=ProjectDetailsTest
```
Expected: Test passes successfully.

- [ ] **Step 4: Commit**

Run:
```bash
git add .
git commit -m "feat: create projects catalog, detail views with tabbed showcase, and add verification tests"
```

---

### Task 7: Contact Form & Message Inbox

**Files:**
- Create: `resources/views/contact.blade.php`
- Create: `tests/Feature/ContactFormTest.php`

**Interfaces:**
- Consumes: `Message` model and routes configured in Task 5.
- Produces: Functional contact form that records message in SQLite database and redirects back with alert.

- [ ] **Step 1: Create Contact View**

Create `resources/views/contact.blade.php` with:
```html
@extends('layouts.app')

@section('content')
<h1 style="font-size: 2rem; font-weight:700; margin-bottom: 2rem;">Hubungi Saya</h1>

<div class="bento-card" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    @if(session('success'))
        <div style="background-color: rgba(52, 199, 89, 0.15); color:#34c759; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight:500;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" style="display:flex; flex-direction:column; gap: 1.25rem;">
        @csrf
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="name" style="font-weight:500;">Nama</label>
            <input type="text" name="name" id="name" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none;">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="email" style="font-weight:500;">Email</label>
            <input type="email" name="email" id="email" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none;">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="message" style="font-weight:500;">Pesan</label>
            <textarea name="message" id="message" rows="5" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none; resize:vertical;"></textarea>
        </div>

        <button type="submit" class="btn" style="border:none; cursor:pointer; width:100%; margin-top:0.5rem;">Kirim Pesan</button>
    </form>
</div>
@endsection
```

- [ ] **Step 2: Write Contact Form Submission Test**

Create `tests/Feature/ContactFormTest.php` with:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_saves_message_successfully(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'message' => 'This is a test message.'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Pesan Anda berhasil terkirim!');
        
        $this->assertDatabaseHas('messages', [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'message' => 'This is a test message.'
        ]);
    }
}
```

Run:
```bash
php artisan test --filter=ContactFormTest
```
Expected: Test passes successfully.

- [ ] **Step 3: Commit**

Run:
```bash
git add .
git commit -m "feat: complete contact form blade template, store logic, and verification tests"
```

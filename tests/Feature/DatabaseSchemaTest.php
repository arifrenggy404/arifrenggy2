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

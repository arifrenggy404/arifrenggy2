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

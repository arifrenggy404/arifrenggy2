<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_access_admin_dashboard(): void
    {
        $user = User::create([
            'name' => 'Arif Renggy',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
    }
}

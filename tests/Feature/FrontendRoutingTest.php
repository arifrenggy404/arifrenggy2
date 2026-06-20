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

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

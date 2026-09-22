<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationLockoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_cannot_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertNotFound();
    }

    public function test_users_cannot_register_via_post(): void
    {
        $response = $this->post('/register', [
            'name' => 'Intruder',
            'email' => 'intruder@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertNotFound();
    }
}

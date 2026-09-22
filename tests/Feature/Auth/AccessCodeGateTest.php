<?php

namespace Tests\Feature\Auth;

use App\Mail\AccessCodeResetMail;
use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AccessCodeGateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed access code and admin
        AccessCode::create([
            'code_hash' => Hash::make('123456'),
            'failed_attempts' => 0,
        ]);

        User::factory()->create([
            'email' => 'admin@portfolio.local',
        ]);
    }

    public function test_login_screen_redirects_to_access_gate_for_unverified_guests(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect(route('access-gate.show'));
    }

    public function test_access_gate_screen_can_be_rendered(): void
    {
        $response = $this->get(route('access-gate.show'));

        $response->assertOk();
    }

    public function test_invalid_pin_fails_verification(): void
    {
        $response = $this->post(route('access-gate.verify'), [
            'code' => '999999',
        ]);

        $response->assertSessionHasErrors(['code']);
        $this->assertFalse(session('access_code_verified', false));
    }

    public function test_valid_pin_unlocks_login_screen(): void
    {
        $response = $this->post(route('access-gate.verify'), [
            'code' => '123456',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(session('access_code_verified', false));

        // Now visiting /login succeeds
        $loginResponse = $this->get('/login');
        $loginResponse->assertOk();
    }

    public function test_forgot_pin_sends_reset_email(): void
    {
        Mail::fake();

        $response = $this->post(route('access-gate.forgot'));

        $response->assertSessionHas('status');
        Mail::assertSent(AccessCodeResetMail::class);
    }

    public function test_reset_pin_with_valid_token_updates_access_code(): void
    {
        $token = 'test-token-1234567890';
        $accessCode = AccessCode::first();
        $accessCode->update([
            'reset_token' => hash('sha256', $token),
            'reset_expires_at' => now()->addMinutes(30),
        ]);

        $response = $this->post(route('access-gate.update'), [
            'token' => $token,
            'code' => '654321',
            'code_confirmation' => '654321',
        ]);

        $response->assertRedirect(route('access-gate.show'));
        $this->assertTrue(AccessCode::checkCode('654321'));
        $this->assertFalse(AccessCode::checkCode('123456'));
    }
}

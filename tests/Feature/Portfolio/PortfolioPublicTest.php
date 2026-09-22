<?php

namespace Tests\Feature\Portfolio;

use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_portfolio_homepage(): void
    {
        PortfolioProfile::create([
            'name' => 'John Doe',
            'title' => 'Software Architect',
            'is_available' => true,
        ]);

        Project::create([
            'title' => 'Alpha App',
            'slug' => 'alpha-app',
            'summary' => 'Alpha App description',
            'is_featured' => true,
        ]);

        Skill::create([
            'name' => 'Laravel',
            'category' => 'Backend',
            'proficiency' => 95,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('profile')
            ->has('featuredProjects', 1)
            ->has('skills.Backend', 1)
        );
    }

    public function test_guest_can_submit_contact_message(): void
    {
        $response = $this->post(route('portfolio.contact'), [
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'Hello, I have an inquiry about system architecture.',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'subject' => 'Project Inquiry',
        ]);
    }

    public function test_honeypot_traps_automated_spam(): void
    {
        $response = $this->post(route('portfolio.contact'), [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'subject' => 'Spam Link',
            'message' => 'Buy our fake products here',
            'website_hp' => 'http://spam.org', // Honeypot filled
        ]);

        // Honeypot should not store message in database
        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spammer.com',
        ]);
    }
}

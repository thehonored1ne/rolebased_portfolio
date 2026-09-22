<?php

namespace Tests\Feature\Admin;

use App\Models\AccessCode;
use App\Models\ContactMessage;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PortfolioCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@portfolio.local',
        ]);

        AccessCode::create([
            'code_hash' => Hash::make('123456'),
        ]);

        PortfolioProfile::create([
            'id' => 1,
            'name' => 'Initial Name',
            'title' => 'Initial Title',
            'is_available' => true,
        ]);
    }

    public function test_guests_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        // Since EnsureAccessCodeGatePassed intercepts login, unverified guests redirect to gate
        $response->assertRedirect();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_admin_can_update_portfolio_profile(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name' => 'Updated Admin Name',
            'title' => 'Lead Systems Architect',
            'bio' => 'Updated bio content here.',
            'contact_email' => 'updated@portfolio.local',
            'is_available' => false,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('portfolio_profiles', [
            'id' => 1,
            'name' => 'Updated Admin Name',
            'title' => 'Lead Systems Architect',
            'is_available' => false,
        ]);
    }

    public function test_admin_can_manage_projects(): void
    {
        // 1. Create Project
        $createResponse = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'E-Commerce Engine',
            'summary' => 'High speed checkout service',
            'is_featured' => true,
            'tech_stack' => ['Laravel', 'Vue 3'],
        ]);

        $createResponse->assertSessionHas('status');
        $project = Project::where('title', 'E-Commerce Engine')->first();
        $this->assertNotNull($project);

        // 2. Update Project
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), [
            'title' => 'E-Commerce Engine v2',
            'summary' => 'Updated summary',
            'is_featured' => false,
            'tech_stack' => ['Laravel', 'TypeScript'],
        ]);

        $updateResponse->assertSessionHas('status');
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'E-Commerce Engine v2',
        ]);

        // 3. Delete Project
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.projects.destroy', $project));
        $deleteResponse->assertSessionHas('status');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_admin_can_manage_skills(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.skills.store'), [
            'name' => 'Rust',
            'category' => 'Backend',
            'proficiency' => 80,
            'sort_order' => 5,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('skills', ['name' => 'Rust']);
    }

    public function test_admin_can_toggle_message_read_and_delete(): void
    {
        $message = ContactMessage::create([
            'name' => 'Client',
            'email' => 'client@corp.com',
            'subject' => 'Hiring',
            'message' => 'Details',
            'is_read' => false,
        ]);

        $toggleResponse = $this->actingAs($this->admin)->patch(route('admin.messages.read', $message));
        $toggleResponse->assertRedirect();
        $this->assertTrue($message->fresh()->is_read);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.messages.destroy', $message));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_update_access_code_pin(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.access-code.update'), [
            'code' => '888888',
            'code_confirmation' => '888888',
        ]);

        $response->assertSessionHas('status');
        $this->assertTrue(AccessCode::checkCode('888888'));
    }
}

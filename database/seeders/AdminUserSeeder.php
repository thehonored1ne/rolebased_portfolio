<?php

namespace Database\Seeders;

use App\Models\AccessCode;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the single admin user, access code, and initial portfolio data.
     */
    public function run(): void
    {
        // 1. Single Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@portfolio.local'],
            [
                'name' => 'Portfolio Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Initial Secret 6-Digit Access Code PIN (Default: 123456)
        if (AccessCode::count() === 0) {
            AccessCode::create([
                'code_hash' => Hash::make('123456'),
                'failed_attempts' => 0,
            ]);
        }

        // 3. Portfolio Profile
        PortfolioProfile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Alex Rivera',
                'title' => 'Senior Full-Stack Engineer & System Architect',
                'bio' => 'Passionate software craftsman building robust, high-performance web applications and distributed systems. Focused on clean architecture, security, and delightful user experiences.',
                'avatar_url' => null,
                'resume_url' => '#',
                'contact_email' => 'alex@example.com',
                'location' => 'San Francisco, CA',
                'github_url' => 'https://github.com',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://x.com',
                'is_available' => true,
            ]
        );

        // 4. Sample Skills
        $skills = [
            ['name' => 'Vue 3 / Inertia.js', 'category' => 'Frontend', 'icon' => 'Code', 'proficiency' => 95, 'sort_order' => 1],
            ['name' => 'TypeScript', 'category' => 'Frontend', 'icon' => 'FileCode', 'proficiency' => 90, 'sort_order' => 2],
            ['name' => 'Tailwind CSS v4', 'category' => 'Frontend', 'icon' => 'Palette', 'proficiency' => 92, 'sort_order' => 3],
            ['name' => 'Laravel 13', 'category' => 'Backend', 'icon' => 'Server', 'proficiency' => 98, 'sort_order' => 4],
            ['name' => 'PHP 8.4', 'category' => 'Backend', 'icon' => 'Cpu', 'proficiency' => 95, 'sort_order' => 5],
            ['name' => 'PostgreSQL / MySQL', 'category' => 'Backend', 'icon' => 'Database', 'proficiency' => 88, 'sort_order' => 6],
            ['name' => 'Docker & Kubernetes', 'category' => 'DevOps', 'icon' => 'Container', 'proficiency' => 82, 'sort_order' => 7],
            ['name' => 'CI/CD & GitHub Actions', 'category' => 'DevOps', 'icon' => 'GitMerge', 'proficiency' => 85, 'sort_order' => 8],
            ['name' => 'Git & Version Control', 'category' => 'Tools', 'icon' => 'GitBranch', 'proficiency' => 96, 'sort_order' => 9],
            ['name' => 'OWASP Security & Pen-Testing', 'category' => 'Tools', 'icon' => 'ShieldCheck', 'proficiency' => 86, 'sort_order' => 10],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        // 5. Sample Projects
        $projects = [
            [
                'title' => 'CloudOps Observability Platform',
                'slug' => 'cloudops-observability-platform',
                'summary' => 'Real-time telemetry and monitoring dashboard with automated anomaly detection.',
                'description' => 'Architected an event-driven telemetry visualization suite handling over 10M events daily with sub-second querying latency.',
                'demo_url' => 'https://demo.example.com',
                'github_url' => 'https://github.com/example/cloudops',
                'tech_stack' => ['Laravel', 'Vue 3', 'Tailwind', 'Redis', 'WebSockets'],
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'E-Commerce Microservices Gateway',
                'slug' => 'ecommerce-microservices-gateway',
                'summary' => 'High-throughput API gateway with rate-limiting, token-bucket throttling, and JWT validation.',
                'description' => 'Unified 8 microservices under a single secure API layer with automated OpenAPI schema validation.',
                'demo_url' => 'https://gateway.example.com',
                'github_url' => 'https://github.com/example/gateway',
                'tech_stack' => ['PHP 8.4', 'Inertia', 'PostgreSQL', 'Docker'],
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'AI Prompt Workflow Orchestrator',
                'slug' => 'ai-prompt-workflow-orchestrator',
                'summary' => 'DAG-based execution engine for chaining multi-modal AI agents and function calls.',
                'description' => 'Created a visual flowchart builder enabling engineers to compose reliable AI agent chains with structured memory recall.',
                'demo_url' => 'https://ai-orchestrator.example.com',
                'github_url' => 'https://github.com/example/ai-orchestrator',
                'tech_stack' => ['Vue 3', 'TypeScript', 'Tailwind CSS', 'Laravel API'],
                'is_featured' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }

        // 6. Sample Experiences
        $experiences = [
            [
                'role' => 'Lead Full-Stack Engineer',
                'company' => 'Apex Cloud Systems',
                'period' => '2023 - Present',
                'description' => 'Leading a distributed team of 6 engineers architecting scalable enterprise SaaS solutions with Laravel and Vue 3.',
                'sort_order' => 1,
            ],
            [
                'role' => 'Senior Backend Developer',
                'company' => 'Nexus Software Labs',
                'period' => '2021 - 2023',
                'description' => 'Engineered secure payment workflows, automated billing pipelines, and optimized relational database performance.',
                'sort_order' => 2,
            ],
            [
                'role' => 'Full-Stack Developer',
                'company' => 'Digital Forge Agency',
                'period' => '2019 - 2021',
                'description' => 'Built and shipped over 20 customer-facing web applications with modern frontend frameworks and clean API design.',
                'sort_order' => 3,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::firstOrCreate(['company' => $experience['company'], 'role' => $experience['role']], $experience);
        }
    }
}

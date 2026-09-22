<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from '@/lib/route';
import {
    ArrowUpRight,
    Briefcase,
    CheckCircle2,
    Code,
    Cpu,
    ExternalLink,
    FileText,
    FolderGit2,
    Globe,
    Layers,
    Lock,
    Mail,
    MapPin,
    Send,
    Server,
    Share2,
    Shield,
    Terminal,
    Wrench,
} from '@lucide/vue';
import { computed, ref } from 'vue';

interface Profile {
    id: number;
    name: string;
    title: string;
    bio: string | null;
    avatar_url: string | null;
    resume_url: string | null;
    contact_email: string | null;
    location: string | null;
    github_url: string | null;
    linkedin_url: string | null;
    twitter_url: string | null;
    is_available: boolean;
}

interface Project {
    id: number;
    title: string;
    slug: string;
    summary: string;
    description: string | null;
    demo_url: string | null;
    github_url: string | null;
    thumbnail_url: string | null;
    tech_stack: string[] | null;
    is_featured: boolean;
    sort_order: number;
}

interface Skill {
    id: number;
    name: string;
    category: string;
    icon: string | null;
    proficiency: number;
    sort_order: number;
}

interface Experience {
    id: number;
    role: string;
    company: string;
    period: string;
    description: string;
    sort_order: number;
}

const props = defineProps<{
    profile: Profile;
    featuredProjects: Project[];
    allProjects: Project[];
    skills: Record<string, Skill[]>;
    experiences: Experience[];
    status?: string;
    isAdmin: boolean;
}>();

const activeProjectFilter = ref<'featured' | 'all'>('featured');

const displayedProjects = computed(() => {
    return activeProjectFilter.value === 'featured'
        ? props.featuredProjects
        : props.allProjects;
});

// Contact Form
const contactForm = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
    website_hp: '', // Honeypot
});

const submitContact = () => {
    contactForm.post(route('portfolio.contact'), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
        },
    });
};

const getCategoryIcon = (category: string) => {
    switch (category.toLowerCase()) {
        case 'frontend':
            return Code;
        case 'backend':
            return Server;
        case 'devops':
            return Cpu;
        default:
            return Wrench;
    }
};
</script>

<template>
    <Head :title="`${profile.name} — ${profile.title}`" />

    <div
        class="min-h-screen bg-zinc-950 text-zinc-100 selection:bg-zinc-800 selection:text-white"
    >
        <!-- Navigation -->
        <header
            class="sticky top-0 z-50 border-b border-zinc-800/80 bg-zinc-950/80 backdrop-blur-md"
        >
            <div
                class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4"
            >
                <a
                    href="#hero"
                    class="text-lg font-bold tracking-tight text-white transition-opacity hover:opacity-80"
                >
                    {{ profile.name }}
                </a>

                <nav
                    class="hidden items-center gap-8 text-sm font-medium text-zinc-400 md:flex"
                >
                    <a href="#about" class="transition-colors hover:text-white"
                        >About</a
                    >
                    <a
                        href="#projects"
                        class="transition-colors hover:text-white"
                        >Projects</a
                    >
                    <a href="#skills" class="transition-colors hover:text-white"
                        >Skills</a
                    >
                    <a
                        href="#experience"
                        class="transition-colors hover:text-white"
                        >Experience</a
                    >
                    <a
                        href="#contact"
                        class="transition-colors hover:text-white"
                        >Contact</a
                    >
                </nav>

                <div class="flex items-center gap-3">
                    <Link
                        v-if="isAdmin"
                        :href="route('dashboard')"
                        class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-400 transition-colors hover:bg-emerald-500/20"
                    >
                        CMS Dashboard
                    </Link>
                    <a
                        href="#contact"
                        class="rounded-lg bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-950 transition-colors hover:bg-white"
                    >
                        Hire Me
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section
            id="hero"
            class="relative overflow-hidden border-b border-zinc-800/50 py-24 md:py-32"
        >
            <div
                class="absolute -top-40 left-1/2 -z-10 h-96 w-[600px] -translate-x-1/2 rounded-full bg-emerald-500/10 blur-[120px]"
            />

            <div class="mx-auto max-w-6xl px-6">
                <!-- Status Pill -->
                <div
                    class="mb-8 inline-flex items-center gap-2.5 rounded-full border border-zinc-800 bg-zinc-900/90 px-3.5 py-1.5 text-xs font-medium text-zinc-300"
                >
                    <span
                        class="h-2 w-2 rounded-full"
                        :class="
                            profile.is_available
                                ? 'animate-pulse bg-emerald-500'
                                : 'bg-amber-500'
                        "
                    />
                    {{
                        profile.is_available
                            ? 'Available for new engineering opportunities'
                            : 'Currently engaged in active projects'
                    }}
                </div>

                <div class="max-w-3xl">
                    <h1
                        class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl md:text-7xl"
                    >
                        {{ profile.name }}
                    </h1>
                    <p
                        class="mt-4 text-xl font-medium text-emerald-400 sm:text-2xl"
                    >
                        {{ profile.title }}
                    </p>
                    <p
                        class="mt-6 text-base leading-relaxed text-zinc-400 sm:text-lg"
                    >
                        {{ profile.bio }}
                    </p>

                    <!-- Meta info & Socials -->
                    <div
                        class="mt-8 flex flex-wrap items-center gap-6 text-sm text-zinc-400"
                    >
                        <div
                            v-if="profile.location"
                            class="flex items-center gap-2"
                        >
                            <MapPin class="h-4 w-4 text-zinc-500" />
                            <span>{{ profile.location }}</span>
                        </div>
                        <div
                            v-if="profile.contact_email"
                            class="flex items-center gap-2"
                        >
                            <Mail class="h-4 w-4 text-zinc-500" />
                            <a
                                :href="`mailto:${profile.contact_email}`"
                                class="transition-colors hover:text-white"
                            >
                                {{ profile.contact_email }}
                            </a>
                        </div>
                    </div>

                    <!-- Call to Actions -->
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a
                            href="#projects"
                            class="inline-flex items-center gap-2 rounded-lg bg-zinc-100 px-5 py-3 text-sm font-semibold text-zinc-950 transition-all hover:bg-white hover:shadow-lg hover:shadow-zinc-100/10"
                        >
                            View Projects
                            <ArrowUpRight class="h-4 w-4" />
                        </a>
                        <a
                            v-if="profile.resume_url"
                            :href="profile.resume_url"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg border border-zinc-800 bg-zinc-900/60 px-5 py-3 text-sm font-semibold text-zinc-200 transition-colors hover:border-zinc-700 hover:bg-zinc-800 hover:text-white"
                        >
                            <FileText class="h-4 w-4" />
                            Download Resume
                        </a>

                        <div class="flex items-center gap-2 pl-2">
                            <a
                                v-if="profile.github_url"
                                :href="profile.github_url"
                                target="_blank"
                                rel="noreferrer"
                                class="rounded-lg border border-zinc-800 p-2.5 text-zinc-400 transition-colors hover:border-zinc-700 hover:text-white"
                                aria-label="GitHub"
                            >
                                <FolderGit2 class="h-4 w-4" />
                            </a>
                            <a
                                v-if="profile.linkedin_url"
                                :href="profile.linkedin_url"
                                target="_blank"
                                rel="noreferrer"
                                class="rounded-lg border border-zinc-800 p-2.5 text-zinc-400 transition-colors hover:border-zinc-700 hover:text-white"
                                aria-label="LinkedIn"
                            >
                                <Globe class="h-4 w-4" />
                            </a>
                            <a
                                v-if="profile.twitter_url"
                                :href="profile.twitter_url"
                                target="_blank"
                                rel="noreferrer"
                                class="rounded-lg border border-zinc-800 p-2.5 text-zinc-400 transition-colors hover:border-zinc-700 hover:text-white"
                                aria-label="Twitter / X"
                            >
                                <Share2 class="h-4 w-4" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="border-b border-zinc-800/50 py-24">
            <div class="mx-auto max-w-6xl px-6">
                <div
                    class="flex flex-col justify-between gap-4 md:flex-row md:items-end"
                >
                    <div>
                        <span
                            class="text-xs font-semibold tracking-widest text-emerald-400 uppercase"
                            >Portfolio</span
                        >
                        <h2
                            class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                        >
                            Featured Works
                        </h2>
                    </div>

                    <!-- Filter Toggle -->
                    <div
                        class="inline-flex rounded-lg border border-zinc-800 bg-zinc-900/80 p-1 text-xs font-medium"
                    >
                        <button
                            type="button"
                            @click="activeProjectFilter = 'featured'"
                            class="rounded-md px-3 py-1.5 transition-colors"
                            :class="
                                activeProjectFilter === 'featured'
                                    ? 'bg-zinc-800 text-white shadow-sm'
                                    : 'text-zinc-400 hover:text-white'
                            "
                        >
                            Featured ({{ featuredProjects.length }})
                        </button>
                        <button
                            type="button"
                            @click="activeProjectFilter = 'all'"
                            class="rounded-md px-3 py-1.5 transition-colors"
                            :class="
                                activeProjectFilter === 'all'
                                    ? 'bg-zinc-800 text-white shadow-sm'
                                    : 'text-zinc-400 hover:text-white'
                            "
                        >
                            All Projects ({{ allProjects.length }})
                        </button>
                    </div>
                </div>

                <div
                    class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="project in displayedProjects"
                        :key="project.id"
                        class="group flex flex-col justify-between rounded-xl border border-zinc-800/80 bg-zinc-900/40 p-6 transition-all duration-300 hover:-translate-y-1 hover:border-zinc-700 hover:bg-zinc-900/80 hover:shadow-xl hover:shadow-zinc-950/50"
                    >
                        <div>
                            <div
                                class="flex items-center justify-between gap-4"
                            >
                                <h3
                                    class="text-lg font-bold text-white transition-colors group-hover:text-emerald-400"
                                >
                                    {{ project.title }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <a
                                        v-if="project.github_url"
                                        :href="project.github_url"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="text-zinc-400 transition-colors hover:text-white"
                                        title="View Source Code"
                                    >
                                        <FolderGit2 class="h-4 w-4" />
                                    </a>
                                    <a
                                        v-if="project.demo_url"
                                        :href="project.demo_url"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="text-zinc-400 transition-colors hover:text-white"
                                        title="Live Demo"
                                    >
                                        <ExternalLink class="h-4 w-4" />
                                    </a>
                                </div>
                            </div>

                            <p
                                class="mt-3 text-sm leading-relaxed text-zinc-400"
                            >
                                {{ project.summary }}
                            </p>
                        </div>

                        <div class="mt-6 border-t border-zinc-800/60 pt-4">
                            <div class="flex flex-wrap gap-1.5">
                                <span
                                    v-for="(tech, i) in project.tech_stack ||
                                    []"
                                    :key="i"
                                    class="rounded bg-zinc-800/80 px-2 py-0.5 text-xs font-medium text-zinc-300"
                                >
                                    {{ tech }}
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="border-b border-zinc-800/50 py-24">
            <div class="mx-auto max-w-6xl px-6">
                <div>
                    <span
                        class="text-xs font-semibold tracking-widest text-emerald-400 uppercase"
                        >Capabilities</span
                    >
                    <h2
                        class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        Technical Arsenal
                    </h2>
                </div>

                <div
                    class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(categorySkills, categoryName) in skills"
                        :key="categoryName"
                        class="rounded-xl border border-zinc-800/80 bg-zinc-900/30 p-6"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-400"
                            >
                                <component
                                    :is="getCategoryIcon(String(categoryName))"
                                    class="h-5 w-5"
                                />
                            </div>
                            <h3 class="text-base font-bold text-white">
                                {{ categoryName }}
                            </h3>
                        </div>

                        <ul class="mt-6 space-y-4">
                            <li
                                v-for="skill in categorySkills"
                                :key="skill.id"
                                class="flex flex-col gap-1.5"
                            >
                                <div
                                    class="flex items-center justify-between text-xs font-medium"
                                >
                                    <span class="text-zinc-200">{{
                                        skill.name
                                    }}</span>
                                    <span class="text-zinc-500"
                                        >{{ skill.proficiency }}%</span
                                    >
                                </div>
                                <div
                                    class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-800"
                                >
                                    <div
                                        class="h-full rounded-full bg-emerald-500 transition-all duration-500"
                                        :style="{
                                            width: `${skill.proficiency}%`,
                                        }"
                                    />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience Timeline -->
        <section id="experience" class="border-b border-zinc-800/50 py-24">
            <div class="mx-auto max-w-4xl px-6">
                <div class="text-center">
                    <span
                        class="text-xs font-semibold tracking-widest text-emerald-400 uppercase"
                        >Journey</span
                    >
                    <h2
                        class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        Work Experience
                    </h2>
                </div>

                <div
                    class="relative mt-16 pl-6 before:absolute before:top-2 before:left-2 before:h-[calc(100%-20px)] before:w-0.5 before:bg-zinc-800"
                >
                    <div
                        v-for="exp in experiences"
                        :key="exp.id"
                        class="relative mb-12 last:mb-0"
                    >
                        <span
                            class="absolute top-1.5 -left-[23px] h-3 w-3 rounded-full border-2 border-zinc-950 bg-emerald-400"
                        />
                        <div
                            class="rounded-xl border border-zinc-800/80 bg-zinc-900/30 p-6"
                        >
                            <div
                                class="flex flex-wrap items-center justify-between gap-2"
                            >
                                <h3 class="text-base font-bold text-white">
                                    {{ exp.role }}
                                </h3>
                                <span
                                    class="rounded bg-zinc-800 px-2.5 py-1 text-xs font-medium text-zinc-400"
                                >
                                    {{ exp.period }}
                                </span>
                            </div>
                            <p
                                class="mt-1 text-sm font-medium text-emerald-400"
                            >
                                {{ exp.company }}
                            </p>
                            <p
                                class="mt-4 text-sm leading-relaxed text-zinc-400"
                            >
                                {{ exp.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section id="contact" class="py-24">
            <div class="mx-auto max-w-3xl px-6">
                <div class="text-center">
                    <span
                        class="text-xs font-semibold tracking-widest text-emerald-400 uppercase"
                        >Get In Touch</span
                    >
                    <h2
                        class="mt-2 text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        Send a Message
                    </h2>
                    <p class="mt-3 text-sm text-zinc-400">
                        Have an opportunity, question, or project in mind? Reach
                        out directly.
                    </p>
                </div>

                <div
                    v-if="status"
                    class="mt-8 rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-center text-sm font-medium text-emerald-400"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submitContact" class="mt-10 space-y-6">
                    <!-- Invisible Honeypot to trap automated bots -->
                    <input
                        type="text"
                        name="website_hp"
                        v-model="contactForm.website_hp"
                        class="hidden"
                        tabindex="-1"
                        autocomplete="off"
                    />

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="name" class="text-zinc-300"
                                >Your Name</Label
                            >
                            <Input
                                id="name"
                                v-model="contactForm.name"
                                required
                                placeholder="Jane Doe"
                                class="border-zinc-800 bg-zinc-900/60 text-white focus:border-emerald-500"
                            />
                            <InputError :message="contactForm.errors.name" />
                        </div>

                        <div class="space-y-2">
                            <Label for="email" class="text-zinc-300"
                                >Email Address</Label
                            >
                            <Input
                                id="email"
                                type="email"
                                v-model="contactForm.email"
                                required
                                placeholder="jane@example.com"
                                class="border-zinc-800 bg-zinc-900/60 text-white focus:border-emerald-500"
                            />
                            <InputError :message="contactForm.errors.email" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label for="subject" class="text-zinc-300"
                            >Subject</Label
                        >
                        <Input
                            id="subject"
                            v-model="contactForm.subject"
                            required
                            placeholder="Engineering project inquiry"
                            class="border-zinc-800 bg-zinc-900/60 text-white focus:border-emerald-500"
                        />
                        <InputError :message="contactForm.errors.subject" />
                    </div>

                    <div class="space-y-2">
                        <Label for="message" class="text-zinc-300"
                            >Message</Label
                        >
                        <textarea
                            id="message"
                            v-model="contactForm.message"
                            rows="5"
                            required
                            placeholder="Hello, I would love to discuss..."
                            class="w-full rounded-md border border-zinc-800 bg-zinc-900/60 p-3 text-sm text-white placeholder-zinc-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                        ></textarea>
                        <InputError :message="contactForm.errors.message" />
                    </div>

                    <Button
                        type="submit"
                        class="w-full bg-emerald-500 font-semibold text-zinc-950 hover:bg-emerald-400"
                        :disabled="contactForm.processing"
                    >
                        <Send class="mr-2 h-4 w-4" />
                        {{
                            contactForm.processing
                                ? 'Sending...'
                                : 'Transmit Message'
                        }}
                    </Button>
                </form>
            </div>
        </section>

        <!-- Footer with Concealed Admin Trigger -->
        <footer class="border-t border-zinc-800/80 bg-zinc-950 py-12">
            <div
                class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-6 text-xs text-zinc-500 sm:flex-row"
            >
                <p>
                    &copy; {{ new Date().getFullYear() }} {{ profile.name }}.
                    All rights reserved.
                </p>

                <div class="flex items-center gap-4">
                    <span>Designed for performance & security</span>

                    <!-- Concealed Admin Trigger: Discreet icon with low opacity -->
                    <Link
                        :href="route('access-gate.show')"
                        class="cursor-default text-zinc-800 transition-colors duration-300 hover:text-zinc-500"
                        title="Portal Gateway"
                        aria-label="Portal Access Gate"
                    >
                        <Shield class="h-3.5 w-3.5" />
                    </Link>
                </div>
            </div>
        </footer>
    </div>
</template>

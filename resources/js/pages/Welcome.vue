<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from '@/lib/route';
import {
    ArrowUpRight,
    Code,
    Cpu,
    ExternalLink,
    FileText,
    FolderGit2,
    Globe,
    Mail,
    MapPin,
    Send,
    Server,
    Share2,
    Shield,
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
        class="min-h-screen bg-[#fafafa] text-black selection:bg-black selection:text-white"
    >
        <!-- Top Navigation -->
        <header
            class="sticky top-0 z-50 border-b-2 border-black bg-[#fafafa]/95 backdrop-blur-md"
        >
            <div
                class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4"
            >
                <a
                    href="#hero"
                    class="group flex items-center gap-2 text-lg font-black tracking-tighter text-black uppercase"
                >
                    <span
                        class="border-2 border-black bg-black px-2 py-0.5 font-mono text-xs font-bold text-white shadow-[2px_2px_0px_0px_#000]"
                    >
                        DEV
                    </span>
                    <span
                        class="transition-transform group-hover:translate-x-0.5"
                    >
                        {{ profile.name }}
                    </span>
                </a>

                <nav
                    class="hidden items-center gap-6 font-mono text-xs font-bold tracking-wider text-black uppercase md:flex"
                >
                    <a
                        href="#about"
                        class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-black"
                    >
                        About
                    </a>
                    <a
                        href="#projects"
                        class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-black"
                    >
                        Projects
                    </a>
                    <a
                        href="#skills"
                        class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-black"
                    >
                        Skills
                    </a>
                    <a
                        href="#experience"
                        class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-black"
                    >
                        Experience
                    </a>
                    <a
                        href="#contact"
                        class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-black"
                    >
                        Contact
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    <Link
                        v-if="isAdmin"
                        :href="route('dashboard')"
                        class="border-2 border-black bg-zinc-200 px-3 py-1.5 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-transform hover:translate-x-[-1px] hover:translate-y-[-1px] hover:shadow-[3px_3px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                    >
                        Admin CMS
                    </Link>

                    <a
                        href="#contact"
                        class="border-2 border-black bg-black px-4 py-2 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                    >
                        Hire Me
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section
            id="hero"
            class="relative border-b-2 border-black py-20 md:py-28"
        >
            <div class="mx-auto max-w-6xl px-6">
                <!-- Status Badge -->
                <div class="mb-8 inline-block">
                    <div
                        class="inline-flex items-center gap-2.5 border-2 border-black bg-white px-3.5 py-1.5 font-mono text-xs font-bold uppercase shadow-[3px_3px_0px_0px_#000]"
                    >
                        <span
                            class="h-2.5 w-2.5 border border-black"
                            :class="
                                profile.is_available
                                    ? 'animate-pulse bg-black'
                                    : 'bg-zinc-400'
                            "
                        />
                        <span>
                            {{
                                profile.is_available
                                    ? 'Status: Available For Hire'
                                    : 'Status: Engaged In Projects'
                            }}
                        </span>
                    </div>
                </div>

                <div class="max-w-4xl">
                    <h1
                        class="text-5xl leading-[0.95] font-black tracking-tighter text-black uppercase sm:text-7xl md:text-8xl"
                    >
                        {{ profile.name }}
                    </h1>

                    <div class="mt-5 inline-block">
                        <span
                            class="border-2 border-black bg-black px-3.5 py-1.5 font-mono text-base font-bold tracking-tight text-white uppercase shadow-[4px_4px_0px_0px_#000] sm:text-xl"
                        >
                            {{ profile.title }}
                        </span>
                    </div>

                    <div
                        id="about"
                        class="mt-8 max-w-3xl border-l-4 border-black pl-5"
                    >
                        <p
                            class="text-base leading-relaxed font-medium text-zinc-800 sm:text-lg"
                        >
                            {{ profile.bio }}
                        </p>
                    </div>

                    <!-- Meta Information -->
                    <div
                        class="mt-8 flex flex-wrap items-center gap-4 font-mono text-xs font-bold text-black uppercase"
                    >
                        <div
                            v-if="profile.location"
                            class="inline-flex items-center gap-2 border-2 border-black bg-white px-3 py-1.5 shadow-[2px_2px_0px_0px_#000]"
                        >
                            <MapPin class="h-3.5 w-3.5" />
                            <span>{{ profile.location }}</span>
                        </div>

                        <div
                            v-if="profile.contact_email"
                            class="inline-flex items-center gap-2 border-2 border-black bg-white px-3 py-1.5 shadow-[2px_2px_0px_0px_#000]"
                        >
                            <Mail class="h-3.5 w-3.5" />
                            <a
                                :href="`mailto:${profile.contact_email}`"
                                class="hover:underline"
                            >
                                {{ profile.contact_email }}
                            </a>
                        </div>
                    </div>

                    <!-- Action CTAs & Social Links -->
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a
                            href="#projects"
                            class="inline-flex items-center gap-2 border-2 border-black bg-black px-6 py-3.5 font-mono text-sm font-bold tracking-wider text-white uppercase shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-900 hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                        >
                            Explore Works
                            <ArrowUpRight class="h-4 w-4" />
                        </a>

                        <a
                            v-if="profile.resume_url"
                            :href="profile.resume_url"
                            target="_blank"
                            class="inline-flex items-center gap-2 border-2 border-black bg-white px-6 py-3.5 font-mono text-sm font-bold tracking-wider text-black uppercase shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-100 hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                        >
                            <FileText class="h-4 w-4" />
                            Download Resume
                        </a>

                        <div class="flex items-center gap-2 sm:ml-2">
                            <a
                                v-if="profile.github_url"
                                :href="profile.github_url"
                                target="_blank"
                                rel="noreferrer"
                                class="flex h-11 w-11 items-center justify-center border-2 border-black bg-white text-black shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-100 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                                aria-label="GitHub"
                            >
                                <FolderGit2 class="h-4 w-4" />
                            </a>

                            <a
                                v-if="profile.linkedin_url"
                                :href="profile.linkedin_url"
                                target="_blank"
                                rel="noreferrer"
                                class="flex h-11 w-11 items-center justify-center border-2 border-black bg-white text-black shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-100 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                                aria-label="LinkedIn"
                            >
                                <Globe class="h-4 w-4" />
                            </a>

                            <a
                                v-if="profile.twitter_url"
                                :href="profile.twitter_url"
                                target="_blank"
                                rel="noreferrer"
                                class="flex h-11 w-11 items-center justify-center border-2 border-black bg-white text-black shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-100 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                                aria-label="Twitter / X"
                            >
                                <Share2 class="h-4 w-4" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marquee Industrial Strip -->
        <div
            class="overflow-hidden border-b-2 border-black bg-black py-3 whitespace-nowrap text-white"
        >
            <div
                class="inline-block font-mono text-xs font-bold tracking-widest uppercase sm:text-sm"
            >
                FULL-STACK ENGINEERING &bull; SECURE BY DESIGN &bull; CLEAN
                ARCHITECTURE &bull; OWASP TOP 10 PROTECTION &bull; VUE 3 &
                INERTIA &bull; LARAVEL &bull; TYPESCRIPT &bull; FULL-STACK
                ENGINEERING &bull; SECURE BY DESIGN &bull; CLEAN ARCHITECTURE
                &bull; OWASP TOP 10 PROTECTION &bull; VUE 3 & INERTIA &bull;
                LARAVEL
            </div>
        </div>

        <!-- Projects Section -->
        <section id="projects" class="border-b-2 border-black py-20">
            <div class="mx-auto max-w-6xl px-6">
                <div
                    class="flex flex-col justify-between gap-6 md:flex-row md:items-end"
                >
                    <div>
                        <div class="inline-block">
                            <span
                                class="border-2 border-black bg-black px-2.5 py-1 font-mono text-xs font-bold tracking-widest text-white uppercase shadow-[2px_2px_0px_0px_#000]"
                            >
                                Showcase
                            </span>
                        </div>
                        <h2
                            class="mt-3 text-4xl font-black tracking-tight text-black uppercase sm:text-5xl"
                        >
                            Selected Works
                        </h2>
                    </div>

                    <!-- Brutalist Filter Segmented Control -->
                    <div
                        class="inline-flex border-2 border-black bg-white p-1 shadow-[3px_3px_0px_0px_#000]"
                    >
                        <button
                            type="button"
                            @click="activeProjectFilter = 'featured'"
                            class="px-3.5 py-1.5 font-mono text-xs font-bold uppercase transition-all"
                            :class="
                                activeProjectFilter === 'featured'
                                    ? 'bg-black text-white shadow-[2px_2px_0px_0px_#000]'
                                    : 'text-black hover:bg-zinc-100'
                            "
                        >
                            Featured [{{ featuredProjects.length }}]
                        </button>
                        <button
                            type="button"
                            @click="activeProjectFilter = 'all'"
                            class="px-3.5 py-1.5 font-mono text-xs font-bold uppercase transition-all"
                            :class="
                                activeProjectFilter === 'all'
                                    ? 'bg-black text-white shadow-[2px_2px_0px_0px_#000]'
                                    : 'text-black hover:bg-zinc-100'
                            "
                        >
                            All Works [{{ allProjects.length }}]
                        </button>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div
                    class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="project in displayedProjects"
                        :key="project.id"
                        class="group flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] transition-all duration-200 hover:translate-x-[-3px] hover:translate-y-[-3px] hover:shadow-[8px_8px_0px_0px_#000]"
                    >
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <h3
                                    class="text-xl font-black tracking-tight text-black uppercase decoration-2 underline-offset-4 group-hover:underline"
                                >
                                    {{ project.title }}
                                </h3>

                                <div class="flex shrink-0 items-center gap-2">
                                    <a
                                        v-if="project.github_url"
                                        :href="project.github_url"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-black hover:text-white"
                                        title="Source Code"
                                    >
                                        <FolderGit2 class="h-3.5 w-3.5" />
                                    </a>
                                    <a
                                        v-if="project.demo_url"
                                        :href="project.demo_url"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-black hover:text-white"
                                        title="Live Demo"
                                    >
                                        <ExternalLink class="h-3.5 w-3.5" />
                                    </a>
                                </div>
                            </div>

                            <p
                                class="mt-4 font-sans text-sm leading-relaxed text-zinc-700"
                            >
                                {{ project.summary }}
                            </p>
                        </div>

                        <div class="mt-6 border-t-2 border-black pt-4">
                            <div class="flex flex-wrap gap-1.5">
                                <span
                                    v-for="(tech, i) in project.tech_stack ||
                                    []"
                                    :key="i"
                                    class="border border-black bg-zinc-100 px-2 py-0.5 font-mono text-[11px] font-bold text-black uppercase"
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
        <section id="skills" class="border-b-2 border-black py-20">
            <div class="mx-auto max-w-6xl px-6">
                <div>
                    <div class="inline-block">
                        <span
                            class="border-2 border-black bg-black px-2.5 py-1 font-mono text-xs font-bold tracking-widest text-white uppercase shadow-[2px_2px_0px_0px_#000]"
                        >
                            Stack & Tooling
                        </span>
                    </div>
                    <h2
                        class="mt-3 text-4xl font-black tracking-tight text-black uppercase sm:text-5xl"
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
                        class="border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000]"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center border-2 border-black bg-black text-white shadow-[2px_2px_0px_0px_#000]"
                            >
                                <component
                                    :is="getCategoryIcon(String(categoryName))"
                                    class="h-5 w-5"
                                />
                            </div>
                            <h3
                                class="text-lg font-black tracking-tight text-black uppercase"
                            >
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
                                    class="flex items-center justify-between font-mono text-xs font-bold uppercase"
                                >
                                    <span class="text-black">
                                        {{ skill.name }}
                                    </span>
                                    <span
                                        class="border border-black bg-zinc-100 px-1.5 py-0.5 text-[10px]"
                                    >
                                        {{ skill.proficiency }}%
                                    </span>
                                </div>

                                <!-- Brutalist Progress Bar -->
                                <div
                                    class="h-3 w-full border-2 border-black bg-zinc-100 p-0.5"
                                >
                                    <div
                                        class="h-full bg-black transition-all duration-500"
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

        <!-- Experience Section -->
        <section id="experience" class="border-b-2 border-black py-20">
            <div class="mx-auto max-w-4xl px-6">
                <div>
                    <div class="inline-block">
                        <span
                            class="border-2 border-black bg-black px-2.5 py-1 font-mono text-xs font-bold tracking-widest text-white uppercase shadow-[2px_2px_0px_0px_#000]"
                        >
                            Track Record
                        </span>
                    </div>
                    <h2
                        class="mt-3 text-4xl font-black tracking-tight text-black uppercase sm:text-5xl"
                    >
                        Work Experience
                    </h2>
                </div>

                <div class="mt-12 space-y-8">
                    <div
                        v-for="(exp, index) in experiences"
                        :key="exp.id"
                        class="border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] sm:p-8"
                    >
                        <div
                            class="flex flex-wrap items-center justify-between gap-3"
                        >
                            <div class="flex items-center gap-3">
                                <span
                                    class="border-2 border-black bg-black px-2.5 py-1 font-mono text-xs font-bold text-white shadow-[2px_2px_0px_0px_#000]"
                                >
                                    0{{ index + 1 }}
                                </span>
                                <h3
                                    class="text-xl font-black tracking-tight text-black uppercase"
                                >
                                    {{ exp.role }}
                                </h3>
                            </div>

                            <span
                                class="border-2 border-black bg-zinc-100 px-3 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000]"
                            >
                                {{ exp.period }}
                            </span>
                        </div>

                        <div class="mt-2">
                            <p
                                class="font-mono text-sm font-bold tracking-wide text-zinc-700 uppercase"
                            >
                                @ {{ exp.company }}
                            </p>
                        </div>

                        <div class="mt-4 border-t-2 border-zinc-200 pt-4">
                            <p
                                class="font-sans text-sm leading-relaxed font-medium text-zinc-700"
                            >
                                {{ exp.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20">
            <div class="mx-auto max-w-3xl px-6">
                <div class="text-center">
                    <div class="inline-block">
                        <span
                            class="border-2 border-black bg-black px-2.5 py-1 font-mono text-xs font-bold tracking-widest text-white uppercase shadow-[2px_2px_0px_0px_#000]"
                        >
                            Communication
                        </span>
                    </div>
                    <h2
                        class="mt-3 text-4xl font-black tracking-tight text-black uppercase sm:text-5xl"
                    >
                        Direct Inquiry
                    </h2>
                    <p
                        class="mt-3 font-mono text-xs font-bold tracking-wider text-zinc-600 uppercase"
                    >
                        Have an opportunity, technical challenge, or inquiry?
                        Transmit below.
                    </p>
                </div>

                <!-- Flash Status Alert -->
                <div
                    v-if="status"
                    class="mt-8 border-2 border-black bg-zinc-100 p-4 font-mono text-sm font-bold text-black uppercase shadow-[4px_4px_0px_0px_#000]"
                >
                    [OK] {{ status }}
                </div>

                <form
                    @submit.prevent="submitContact"
                    class="mt-10 space-y-6 border-2 border-black bg-white p-6 shadow-[6px_6px_0px_0px_#000] sm:p-8"
                >
                    <!-- Honeypot -->
                    <input
                        type="text"
                        name="website_hp"
                        v-model="contactForm.website_hp"
                        class="hidden"
                        tabindex="-1"
                        autocomplete="off"
                    />

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label
                                for="name"
                                class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Your Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                v-model="contactForm.name"
                                required
                                placeholder="Jane Doe"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="contactForm.errors.name"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="email"
                                class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Email Address
                            </label>
                            <input
                                id="email"
                                type="email"
                                v-model="contactForm.email"
                                required
                                placeholder="jane@example.com"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="contactForm.errors.email"
                                class="mt-1"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            for="subject"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Subject
                        </label>
                        <input
                            id="subject"
                            type="text"
                            v-model="contactForm.subject"
                            required
                            placeholder="System Architecture / Contract Inquiry"
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError
                            :message="contactForm.errors.subject"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <label
                            for="message"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Transmission Message
                        </label>
                        <textarea
                            id="message"
                            v-model="contactForm.message"
                            rows="5"
                            required
                            placeholder="Detail your engineering requirements or project scope..."
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        ></textarea>
                        <InputError
                            :message="contactForm.errors.message"
                            class="mt-1"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 border-2 border-black bg-black py-4 font-mono text-sm font-bold tracking-widest text-white uppercase shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-900 hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none disabled:opacity-50"
                        :disabled="contactForm.processing"
                    >
                        <Send class="h-4 w-4" />
                        {{
                            contactForm.processing
                                ? 'TRANSMITTING...'
                                : 'TRANSMIT MESSAGE'
                        }}
                    </button>
                </form>
            </div>
        </section>

        <!-- Footer with Concealed Admin Trigger -->
        <footer class="border-t-2 border-black bg-white py-12">
            <div
                class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-6 font-mono text-xs font-bold text-zinc-600 uppercase sm:flex-row"
            >
                <p>
                    &copy; {{ new Date().getFullYear() }} {{ profile.name }}.
                    ALL RIGHTS RESERVED.
                </p>

                <div class="flex items-center gap-4">
                    <span>SECURITY FIRST // PERFORMANCE ENGINE</span>

                    <!-- Concealed Admin Trigger: Discreet icon with minimal contrast -->
                    <Link
                        :href="route('access-gate.show')"
                        class="cursor-default text-zinc-300 transition-colors duration-300 hover:text-black"
                        title="Sys"
                        aria-label="Access Gateway"
                    >
                        <Shield class="h-3 w-3" />
                    </Link>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ExternalLink, FolderGit2, Plus, Trash2, X } from '@lucide/vue';
import { ref } from 'vue';

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

const props = defineProps<{
    projects: Project[];
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Projects Manager', href: route('admin.projects.index') },
];

const showModal = ref(false);
const editingProject = ref<Project | null>(null);

const form = useForm({
    title: '',
    slug: '',
    summary: '',
    description: '',
    demo_url: '',
    github_url: '',
    tech_stack_input: '',
    is_featured: false,
    sort_order: 0,
});

const openCreateModal = () => {
    editingProject.value = null;
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

const openEditModal = (project: Project) => {
    editingProject.value = project;
    form.clearErrors();
    form.title = project.title;
    form.slug = project.slug;
    form.summary = project.summary;
    form.description = project.description ?? '';
    form.demo_url = project.demo_url ?? '';
    form.github_url = project.github_url ?? '';
    form.tech_stack_input = (project.tech_stack || []).join(', ');
    form.is_featured = project.is_featured;
    form.sort_order = project.sort_order;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingProject.value = null;
};

const saveProject = () => {
    const techStackArray = form.tech_stack_input
        .split(',')
        .map((s) => s.trim())
        .filter(Boolean);

    const payload = {
        title: form.title,
        slug: form.slug || undefined,
        summary: form.summary,
        description: form.description,
        demo_url: form.demo_url || null,
        github_url: form.github_url || null,
        tech_stack: techStackArray,
        is_featured: form.is_featured,
        sort_order: form.sort_order,
    };

    if (editingProject.value) {
        router.put(
            route('admin.projects.update', editingProject.value.id),
            payload,
            {
                onSuccess: () => closeModal(),
            },
        );
    } else {
        router.post(route('admin.projects.store'), payload, {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteProject = (id: number) => {
    if (confirm('Are you sure you want to delete this project?')) {
        router.delete(route('admin.projects.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Projects Manager" />

        <div
            class="flex min-h-screen flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
            >
                <div>
                    <div class="mb-1 inline-block">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                        >
                            PORTFOLIO SHOWCASE
                        </span>
                    </div>
                    <h1
                        class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                    >
                        Projects Manager
                    </h1>
                    <p
                        class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                    >
                        Create, modify, and feature your software development
                        works.
                    </p>
                </div>

                <button
                    type="button"
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 border-2 border-black bg-black px-4 py-2.5 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                >
                    <Plus class="h-4 w-4" />
                    New Project
                </button>
            </div>

            <div
                v-if="status"
                class="border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[3px_3px_0px_0px_#000]"
            >
                [OK] {{ status }}
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="project in projects"
                    :key="project.id"
                    class="flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[7px_7px_0px_0px_#000]"
                >
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <h3
                                class="text-lg font-black tracking-tight text-black uppercase"
                            >
                                {{ project.title }}
                            </h3>
                            <span
                                v-if="project.is_featured"
                                class="border border-black bg-black px-2 py-0.5 font-mono text-[9px] font-bold tracking-wider text-white uppercase"
                            >
                                FEATURED
                            </span>
                        </div>

                        <p
                            class="mt-3 font-sans text-xs leading-relaxed text-zinc-700"
                        >
                            {{ project.summary }}
                        </p>

                        <div class="mt-4 flex flex-wrap gap-1.5">
                            <span
                                v-for="(tag, i) in project.tech_stack || []"
                                :key="i"
                                class="border border-black bg-zinc-100 px-2 py-0.5 font-mono text-[10px] font-bold text-black uppercase"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-6 flex items-center justify-between border-t-2 border-black pt-4"
                    >
                        <div class="flex items-center gap-2">
                            <a
                                v-if="project.github_url"
                                :href="project.github_url"
                                target="_blank"
                                class="flex h-7 w-7 items-center justify-center border-2 border-black bg-white text-black shadow-[1px_1px_0px_0px_#000] transition-all hover:bg-black hover:text-white"
                                title="Repository"
                            >
                                <FolderGit2 class="h-3.5 w-3.5" />
                            </a>
                            <a
                                v-if="project.demo_url"
                                :href="project.demo_url"
                                target="_blank"
                                class="flex h-7 w-7 items-center justify-center border-2 border-black bg-white text-black shadow-[1px_1px_0px_0px_#000] transition-all hover:bg-black hover:text-white"
                                title="Live Demo"
                            >
                                <ExternalLink class="h-3.5 w-3.5" />
                            </a>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="openEditModal(project)"
                                class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                @click="deleteProject(project.id)"
                                class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Create / Edit -->
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            >
                <div
                    class="max-h-[90vh] w-full max-w-xl overflow-y-auto border-2 border-black bg-white p-6 shadow-[8px_8px_0px_0px_#000] sm:p-8"
                >
                    <div
                        class="flex items-center justify-between border-b-2 border-black pb-4"
                    >
                        <h2
                            class="text-xl font-black tracking-tight text-black uppercase"
                        >
                            {{
                                editingProject ? 'Edit Project' : 'New Project'
                            }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>

                    <form @submit.prevent="saveProject" class="mt-6 space-y-4">
                        <div>
                            <label
                                for="proj_title"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Project Title
                            </label>
                            <input
                                id="proj_title"
                                type="text"
                                v-model="form.title"
                                required
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.title"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="proj_slug"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                URL Slug (Optional)
                            </label>
                            <input
                                id="proj_slug"
                                type="text"
                                v-model="form.slug"
                                placeholder="e.g. cloudops-platform"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.slug"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="proj_summary"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Summary (Card preview)
                            </label>
                            <input
                                id="proj_summary"
                                type="text"
                                v-model="form.summary"
                                required
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.summary"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="proj_desc"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Full Description
                            </label>
                            <textarea
                                id="proj_desc"
                                v-model="form.description"
                                rows="3"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            ></textarea>
                            <InputError
                                :message="form.errors.description"
                                class="mt-1"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label
                                    for="proj_demo"
                                    class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                                >
                                    Live Demo URL
                                </label>
                                <input
                                    id="proj_demo"
                                    type="text"
                                    v-model="form.demo_url"
                                    placeholder="https://..."
                                    class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                                />
                                <InputError
                                    :message="form.errors.demo_url"
                                    class="mt-1"
                                />
                            </div>

                            <div>
                                <label
                                    for="proj_git"
                                    class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                                >
                                    GitHub Repository URL
                                </label>
                                <input
                                    id="proj_git"
                                    type="text"
                                    v-model="form.github_url"
                                    placeholder="https://github.com/..."
                                    class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                                />
                                <InputError
                                    :message="form.errors.github_url"
                                    class="mt-1"
                                />
                            </div>
                        </div>

                        <div>
                            <label
                                for="proj_tech"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Tech Stack (comma separated)
                            </label>
                            <input
                                id="proj_tech"
                                type="text"
                                v-model="form.tech_stack_input"
                                placeholder="Vue 3, Laravel, Tailwind, Docker"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                        </div>

                        <div class="flex items-center gap-6 pt-2">
                            <div class="flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    id="proj_featured"
                                    v-model="form.is_featured"
                                    class="h-5 w-5 border-2 border-black bg-white text-black focus:ring-0"
                                />
                                <label
                                    for="proj_featured"
                                    class="cursor-pointer font-mono text-xs font-bold text-black uppercase"
                                >
                                    Featured on Home
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <label
                                    for="proj_order"
                                    class="font-mono text-xs font-bold text-black uppercase"
                                >
                                    Sort:
                                </label>
                                <input
                                    id="proj_order"
                                    type="number"
                                    v-model.number="form.sort_order"
                                    class="w-20 border-2 border-black bg-white p-2 font-mono text-xs font-bold text-black focus:outline-none"
                                />
                            </div>
                        </div>

                        <div
                            class="flex justify-end gap-3 border-t-2 border-black pt-4"
                        >
                            <button
                                type="button"
                                @click="closeModal"
                                class="border-2 border-black bg-white px-4 py-2 font-mono text-xs font-bold tracking-wider text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="border-2 border-black bg-black px-5 py-2 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-900"
                            >
                                Save Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

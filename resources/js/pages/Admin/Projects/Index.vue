<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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

        <div class="flex flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Projects Manager
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500">
                        Create, modify, and feature your software development
                        works.
                    </p>
                </div>

                <Button @click="openCreateModal" class="gap-2">
                    <Plus class="h-4 w-4" />
                    New Project
                </Button>
            </div>

            <div
                v-if="status"
                class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-500"
            >
                {{ status }}
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="project in projects"
                    :key="project.id"
                    class="flex flex-col justify-between rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <h3
                                class="text-base font-bold text-zinc-900 dark:text-white"
                            >
                                {{ project.title }}
                            </h3>
                            <span
                                v-if="project.is_featured"
                                class="rounded bg-emerald-500/10 px-2 py-0.5 text-xs font-semibold text-emerald-500"
                            >
                                Featured
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-zinc-500">
                            {{ project.summary }}
                        </p>

                        <div class="mt-4 flex flex-wrap gap-1">
                            <span
                                v-for="(tag, i) in project.tech_stack || []"
                                :key="i"
                                class="rounded bg-zinc-100 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-6 flex items-center justify-between border-t border-zinc-100 pt-4 dark:border-zinc-800"
                    >
                        <div class="flex items-center gap-2">
                            <a
                                v-if="project.github_url"
                                :href="project.github_url"
                                target="_blank"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200"
                            >
                                <FolderGit2 class="h-4 w-4" />
                            </a>
                            <a
                                v-if="project.demo_url"
                                :href="project.demo_url"
                                target="_blank"
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200"
                            >
                                <ExternalLink class="h-4 w-4" />
                            </a>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="openEditModal(project)"
                                class="text-xs font-semibold text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white"
                            >
                                Edit
                            </button>
                            <span class="text-zinc-300 dark:text-zinc-700"
                                >&bull;</span
                            >
                            <button
                                type="button"
                                @click="deleteProject(project.id)"
                                class="text-xs font-semibold text-rose-500 hover:text-rose-600"
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
                    class="max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div
                        class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800"
                    >
                        <h2
                            class="text-lg font-bold text-zinc-900 dark:text-white"
                        >
                            {{
                                editingProject ? 'Edit Project' : 'New Project'
                            }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-white"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form @submit.prevent="saveProject" class="mt-6 space-y-4">
                        <div class="space-y-1">
                            <Label for="proj_title">Project Title</Label>
                            <Input
                                id="proj_title"
                                v-model="form.title"
                                required
                            />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="space-y-1">
                            <Label for="proj_slug">URL Slug (Optional)</Label>
                            <Input
                                id="proj_slug"
                                v-model="form.slug"
                                placeholder="e.g. cloudops-platform"
                            />
                            <InputError :message="form.errors.slug" />
                        </div>

                        <div class="space-y-1">
                            <Label for="proj_summary"
                                >Summary (Short preview for cards)</Label
                            >
                            <Input
                                id="proj_summary"
                                v-model="form.summary"
                                required
                            />
                            <InputError :message="form.errors.summary" />
                        </div>

                        <div class="space-y-1">
                            <Label for="proj_desc">Full Description</Label>
                            <textarea
                                id="proj_desc"
                                v-model="form.description"
                                rows="3"
                                class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm"
                            ></textarea>
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="space-y-1">
                                <Label for="proj_demo">Live Demo URL</Label>
                                <Input
                                    id="proj_demo"
                                    v-model="form.demo_url"
                                    placeholder="https://..."
                                />
                                <InputError :message="form.errors.demo_url" />
                            </div>

                            <div class="space-y-1">
                                <Label for="proj_git"
                                    >GitHub Repository URL</Label
                                >
                                <Input
                                    id="proj_git"
                                    v-model="form.github_url"
                                    placeholder="https://github.com/..."
                                />
                                <InputError :message="form.errors.github_url" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <Label for="proj_tech"
                                >Tech Stack (comma separated)</Label
                            >
                            <Input
                                id="proj_tech"
                                v-model="form.tech_stack_input"
                                placeholder="Vue 3, Laravel, Tailwind, Docker"
                            />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <div class="flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    id="proj_featured"
                                    v-model="form.is_featured"
                                    class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500"
                                />
                                <Label
                                    for="proj_featured"
                                    class="cursor-pointer text-xs"
                                    >Featured on Home</Label
                                >
                            </div>

                            <div class="flex items-center gap-2">
                                <Label for="proj_order" class="text-xs"
                                    >Sort Order:</Label
                                >
                                <Input
                                    id="proj_order"
                                    type="number"
                                    v-model.number="form.sort_order"
                                    class="w-20"
                                />
                            </div>
                        </div>

                        <div
                            class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800"
                        >
                            <Button
                                type="button"
                                variant="outline"
                                @click="closeModal"
                                >Cancel</Button
                            >
                            <Button type="submit">Save Project</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

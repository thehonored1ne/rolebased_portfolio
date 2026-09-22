<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Briefcase,
    CheckCircle,
    Code,
    ExternalLink,
    FileEdit,
    FolderGit2,
    Mail,
    MailOpen,
    Shield,
    Trash2,
} from '@lucide/vue';

interface Stats {
    unread_messages: number;
    total_messages: number;
    total_projects: number;
    total_skills: number;
    total_experiences: number;
}

interface Message {
    id: number;
    name: string;
    email: string;
    subject: string;
    message: string;
    is_read: boolean;
    created_at: string;
}

interface Profile {
    name: string;
    title: string;
    is_available: boolean;
}

const props = defineProps<{
    stats: Stats;
    recentMessages: Message[];
    profile: Profile;
}>();

const breadcrumbs = [
    {
        title: 'CMS Dashboard',
        href: route('dashboard'),
    },
];

const toggleMessageRead = (id: number) => {
    router.patch(
        route('admin.messages.read', id),
        {},
        { preserveScroll: true },
    );
};

const deleteMessage = (id: number) => {
    if (confirm('Delete this message?')) {
        router.delete(route('admin.messages.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Portfolio CMS Dashboard" />

        <div class="flex flex-1 flex-col gap-6 p-6">
            <!-- Welcome Bar -->
            <div
                class="flex flex-col justify-between gap-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm md:flex-row md:items-center dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Welcome back, Admin
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Managing portfolio for
                        <span
                            class="font-semibold text-zinc-800 dark:text-zinc-200"
                            >{{ profile.name }}</span
                        >
                        ({{ profile.title }})
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <Link
                        :href="route('home')"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-300 bg-white px-3.5 py-2 text-xs font-semibold text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                    >
                        <ExternalLink class="h-3.5 w-3.5" />
                        Preview Public Site
                    </Link>

                    <Link
                        :href="route('admin.profile.edit')"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-900 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-950 dark:hover:bg-white"
                    >
                        <FileEdit class="h-3.5 w-3.5" />
                        Edit Profile & Hero
                    </Link>
                </div>
            </div>

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    :href="route('admin.messages.index')"
                    class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="text-xs font-medium tracking-wider text-zinc-500 uppercase"
                            >Inbox</span
                        >
                        <div
                            class="rounded-lg bg-rose-500/10 p-2 text-rose-500"
                        >
                            <Mail class="h-4 w-4" />
                        </div>
                    </div>
                    <p
                        class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white"
                    >
                        {{ stats.unread_messages }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500">
                        {{ stats.total_messages }} total contact submissions
                    </p>
                </Link>

                <Link
                    :href="route('admin.projects.index')"
                    class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="text-xs font-medium tracking-wider text-zinc-500 uppercase"
                            >Projects</span
                        >
                        <div
                            class="rounded-lg bg-blue-500/10 p-2 text-blue-500"
                        >
                            <FolderGit2 class="h-4 w-4" />
                        </div>
                    </div>
                    <p
                        class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white"
                    >
                        {{ stats.total_projects }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500">
                        Managed portfolio projects
                    </p>
                </Link>

                <Link
                    :href="route('admin.skills.index')"
                    class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="text-xs font-medium tracking-wider text-zinc-500 uppercase"
                            >Skills</span
                        >
                        <div
                            class="rounded-lg bg-emerald-500/10 p-2 text-emerald-500"
                        >
                            <Code class="h-4 w-4" />
                        </div>
                    </div>
                    <p
                        class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white"
                    >
                        {{ stats.total_skills }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500">
                        Active technologies listed
                    </p>
                </Link>

                <Link
                    :href="route('admin.experiences.index')"
                    class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="text-xs font-medium tracking-wider text-zinc-500 uppercase"
                            >Experience</span
                        >
                        <div
                            class="rounded-lg bg-purple-500/10 p-2 text-purple-500"
                        >
                            <Briefcase class="h-4 w-4" />
                        </div>
                    </div>
                    <p
                        class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white"
                    >
                        {{ stats.total_experiences }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500">
                        Career timeline items
                    </p>
                </Link>
            </div>

            <!-- Recent Inquiries Table -->
            <div
                class="rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-200 p-6 dark:border-zinc-800"
                >
                    <div>
                        <h2
                            class="text-base font-bold text-zinc-900 dark:text-white"
                        >
                            Recent Guest Messages
                        </h2>
                        <p class="text-xs text-zinc-500">
                            Latest messages submitted via the public portfolio
                        </p>
                    </div>

                    <Link
                        :href="route('admin.messages.index')"
                        class="text-xs font-semibold text-emerald-500 hover:text-emerald-400"
                    >
                        View All ({{ stats.total_messages }})
                    </Link>
                </div>

                <div
                    v-if="recentMessages.length === 0"
                    class="p-8 text-center text-sm text-zinc-500"
                >
                    No inquiries received yet.
                </div>

                <div
                    v-else
                    class="divide-y divide-zinc-200 dark:divide-zinc-800"
                >
                    <div
                        v-for="msg in recentMessages"
                        :key="msg.id"
                        class="flex flex-col justify-between gap-4 p-5 transition-colors hover:bg-zinc-50 sm:flex-row sm:items-center dark:hover:bg-zinc-800/50"
                    >
                        <div class="flex items-start gap-3">
                            <button
                                type="button"
                                @click="toggleMessageRead(msg.id)"
                                class="mt-0.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200"
                                :title="
                                    msg.is_read
                                        ? 'Mark as unread'
                                        : 'Mark as read'
                                "
                            >
                                <CheckCircle
                                    v-if="msg.is_read"
                                    class="h-4 w-4 text-emerald-500"
                                />
                                <Mail v-else class="h-4 w-4 text-rose-500" />
                            </button>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-sm font-semibold text-zinc-900 dark:text-white"
                                        >{{ msg.name }}</span
                                    >
                                    <span class="text-xs text-zinc-400"
                                        >&bull; {{ msg.email }}</span
                                    >
                                </div>
                                <p
                                    class="text-xs font-medium text-zinc-700 dark:text-zinc-300"
                                >
                                    {{ msg.subject }}
                                </p>
                                <p
                                    class="mt-1 line-clamp-1 text-xs text-zinc-500"
                                >
                                    {{ msg.message }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-xs text-zinc-400">{{
                                new Date(msg.created_at).toLocaleDateString()
                            }}</span>
                            <button
                                type="button"
                                @click="deleteMessage(msg.id)"
                                class="rounded p-1 text-zinc-400 transition-colors hover:text-rose-500"
                                title="Delete"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

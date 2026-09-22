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

        <div
            class="flex min-h-screen flex-1 flex-col gap-8 bg-[#fafafa] p-6 text-black"
        >
            <!-- Welcome Bar -->
            <div
                class="flex flex-col justify-between gap-6 border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000] md:flex-row md:items-center"
            >
                <div>
                    <div class="mb-2 inline-block">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold tracking-widest text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                        >
                            SYSTEM CMS
                        </span>
                    </div>
                    <h1
                        class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                    >
                        Dashboard
                    </h1>
                    <p
                        class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                    >
                        Managing Portfolio for {{ profile.name }} &bull;
                        {{ profile.title }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <Link
                        :href="route('home')"
                        target="_blank"
                        class="inline-flex items-center gap-2 border-2 border-black bg-white px-4 py-2 font-mono text-xs font-bold tracking-wider text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-100 hover:shadow-[3px_3px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                    >
                        <ExternalLink class="h-3.5 w-3.5" />
                        Preview Site
                    </Link>

                    <Link
                        :href="route('admin.profile.edit')"
                        class="inline-flex items-center gap-2 border-2 border-black bg-black px-4 py-2 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-900 hover:shadow-[3px_3px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                    >
                        <FileEdit class="h-3.5 w-3.5" />
                        Edit Profile
                    </Link>
                </div>
            </div>

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    :href="route('admin.messages.index')"
                    class="group flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold tracking-wider text-white uppercase"
                        >
                            Messages
                        </span>
                        <div
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000]"
                        >
                            <Mail class="h-4 w-4" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <p
                            class="text-4xl font-black tracking-tight text-black"
                        >
                            {{ stats.unread_messages }}
                        </p>
                        <p
                            class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                        >
                            {{ stats.total_messages }} Total Inquiries
                        </p>
                    </div>
                </Link>

                <Link
                    :href="route('admin.projects.index')"
                    class="group flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold tracking-wider text-white uppercase"
                        >
                            Projects
                        </span>
                        <div
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000]"
                        >
                            <FolderGit2 class="h-4 w-4" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <p
                            class="text-4xl font-black tracking-tight text-black"
                        >
                            {{ stats.total_projects }}
                        </p>
                        <p
                            class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                        >
                            Showcase Works
                        </p>
                    </div>
                </Link>

                <Link
                    :href="route('admin.skills.index')"
                    class="group flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold tracking-wider text-white uppercase"
                        >
                            Skills
                        </span>
                        <div
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000]"
                        >
                            <Code class="h-4 w-4" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <p
                            class="text-4xl font-black tracking-tight text-black"
                        >
                            {{ stats.total_skills }}
                        </p>
                        <p
                            class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                        >
                            Active Capabilities
                        </p>
                    </div>
                </Link>

                <Link
                    :href="route('admin.experiences.index')"
                    class="group flex flex-col justify-between border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold tracking-wider text-white uppercase"
                        >
                            Experience
                        </span>
                        <div
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000]"
                        >
                            <Briefcase class="h-4 w-4" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <p
                            class="text-4xl font-black tracking-tight text-black"
                        >
                            {{ stats.total_experiences }}
                        </p>
                        <p
                            class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                        >
                            Timeline Entries
                        </p>
                    </div>
                </Link>
            </div>

            <!-- Recent Inquiries Table -->
            <div
                class="border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]"
            >
                <div
                    class="flex items-center justify-between border-b-2 border-black bg-[#fafafa] p-6"
                >
                    <div>
                        <div class="mb-1 inline-block">
                            <span
                                class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase"
                            >
                                Feed
                            </span>
                        </div>
                        <h2
                            class="text-xl font-black tracking-tight text-black uppercase"
                        >
                            Recent Guest Messages
                        </h2>
                    </div>

                    <Link
                        :href="route('admin.messages.index')"
                        class="border-2 border-black bg-black px-3.5 py-1.5 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-900 hover:shadow-[3px_3px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                    >
                        View All [{{ stats.total_messages }}]
                    </Link>
                </div>

                <div
                    v-if="recentMessages.length === 0"
                    class="p-12 text-center font-mono text-xs font-bold text-zinc-500 uppercase"
                >
                    [Empty] No inquiries received yet.
                </div>

                <div v-else class="divide-y-2 divide-black">
                    <div
                        v-for="msg in recentMessages"
                        :key="msg.id"
                        class="flex flex-col justify-between gap-4 p-5 transition-colors hover:bg-zinc-50 sm:flex-row sm:items-center"
                    >
                        <div class="flex items-start gap-4">
                            <button
                                type="button"
                                @click="toggleMessageRead(msg.id)"
                                class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center border-2 border-black bg-white text-black shadow-[1px_1px_0px_0px_#000] transition-all hover:bg-zinc-100"
                                :title="
                                    msg.is_read
                                        ? 'Mark as unread'
                                        : 'Mark as read'
                                "
                            >
                                <CheckCircle
                                    v-if="msg.is_read"
                                    class="h-3.5 w-3.5 text-black"
                                />
                                <Mail v-else class="h-3.5 w-3.5 text-black" />
                            </button>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-mono text-sm font-bold text-black uppercase"
                                    >
                                        {{ msg.name }}
                                    </span>
                                    <span
                                        class="font-mono text-xs text-zinc-500"
                                    >
                                        &bull; {{ msg.email }}
                                    </span>
                                    <span
                                        class="py-0.2 border border-black px-1.5 font-mono text-[9px] font-bold uppercase"
                                        :class="
                                            msg.is_read
                                                ? 'bg-zinc-100 text-zinc-600'
                                                : 'bg-black text-white'
                                        "
                                    >
                                        {{ msg.is_read ? 'READ' : 'NEW' }}
                                    </span>
                                </div>
                                <p
                                    class="mt-1 font-mono text-xs font-bold text-black uppercase"
                                >
                                    {{ msg.subject }}
                                </p>
                                <p
                                    class="mt-1 line-clamp-1 font-sans text-xs text-zinc-700"
                                >
                                    {{ msg.message }}
                                </p>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-4">
                            <span
                                class="font-mono text-xs font-bold text-zinc-500 uppercase"
                            >
                                {{
                                    new Date(
                                        msg.created_at,
                                    ).toLocaleDateString()
                                }}
                            </span>
                            <button
                                type="button"
                                @click="deleteMessage(msg.id)"
                                class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                                title="Delete"
                            >
                                <Trash2 class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

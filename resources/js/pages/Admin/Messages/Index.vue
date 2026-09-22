<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { CheckCircle, Mail, MailOpen, Trash2 } from '@lucide/vue';

interface Message {
    id: number;
    name: string;
    email: string;
    subject: string;
    message: string;
    is_read: boolean;
    ip_address: string | null;
    created_at: string;
}

const props = defineProps<{
    messages: Message[];
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Messages Inbox', href: route('admin.messages.index') },
];

const toggleRead = (id: number) => {
    router.patch(
        route('admin.messages.read', id),
        {},
        { preserveScroll: true },
    );
};

const deleteMsg = (id: number) => {
    if (confirm('Permanently delete this message?')) {
        router.delete(route('admin.messages.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Guest Inquiries Inbox" />

        <div class="flex max-w-5xl flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Guest Messages Inbox
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500">
                        Inquiries and contact submissions sent via the public
                        portfolio page.
                    </p>
                </div>
            </div>

            <div
                v-if="status"
                class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-500"
            >
                {{ status }}
            </div>

            <div
                v-if="messages.length === 0"
                class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-sm text-zinc-500 dark:border-zinc-800"
            >
                Inbox is empty. No messages submitted yet.
            </div>

            <div v-else class="space-y-4">
                <div
                    v-for="msg in messages"
                    :key="msg.id"
                    class="rounded-xl border p-5 shadow-sm transition-colors"
                    :class="
                        msg.is_read
                            ? 'border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900/50'
                            : 'border-emerald-500/40 bg-emerald-500/5 dark:bg-emerald-950/20'
                    "
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800"
                    >
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                @click="toggleRead(msg.id)"
                                :title="
                                    msg.is_read ? 'Mark unread' : 'Mark read'
                                "
                                class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200"
                            >
                                <CheckCircle
                                    v-if="msg.is_read"
                                    class="h-4 w-4 text-emerald-500"
                                />
                                <Mail v-else class="h-4 w-4 text-rose-500" />
                            </button>

                            <div>
                                <span
                                    class="text-sm font-bold text-zinc-900 dark:text-white"
                                    >{{ msg.name }}</span
                                >
                                <a
                                    :href="`mailto:${msg.email}`"
                                    class="ml-2 text-xs text-zinc-500 hover:underline"
                                >
                                    {{ msg.email }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-xs text-zinc-400">
                                {{ new Date(msg.created_at).toLocaleString() }}
                            </span>
                            <button
                                type="button"
                                @click="deleteMsg(msg.id)"
                                class="text-zinc-400 transition-colors hover:text-rose-500"
                                title="Delete message"
                            >
                                <Trash2 class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h4
                            class="text-sm font-semibold text-zinc-800 dark:text-zinc-200"
                        >
                            {{ msg.subject }}
                        </h4>
                        <p
                            class="mt-2 text-sm leading-relaxed whitespace-pre-wrap text-zinc-600 dark:text-zinc-400"
                        >
                            {{ msg.message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { CheckCircle, Mail, Trash2 } from '@lucide/vue';

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

        <div
            class="flex min-h-screen w-full flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div>
                <div class="mb-1 inline-block">
                    <span
                        class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                    >
                        COMMUNICATION
                    </span>
                </div>
                <h1
                    class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                >
                    Guest Messages Inbox
                </h1>
                <p
                    class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                >
                    Inquiries and transmissions submitted via the public
                    portfolio page.
                </p>
            </div>

            <div
                v-if="status"
                class="border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[3px_3px_0px_0px_#000]"
            >
                [OK] {{ status }}
            </div>

            <div
                v-if="messages.length === 0"
                class="border-2 border-dashed border-black bg-white p-12 text-center font-mono text-xs font-bold text-zinc-500 uppercase"
            >
                [EMPTY] Inbox is empty. No messages submitted yet.
            </div>

            <div v-else class="space-y-6">
                <div
                    v-for="msg in messages"
                    :key="msg.id"
                    class="border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[7px_7px_0px_0px_#000]"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-zinc-200 pb-4"
                    >
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                @click="toggleRead(msg.id)"
                                :title="
                                    msg.is_read ? 'Mark unread' : 'Mark read'
                                "
                                class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[1px_1px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                            >
                                <CheckCircle
                                    v-if="msg.is_read"
                                    class="h-4 w-4 text-black"
                                />
                                <Mail v-else class="h-4 w-4 text-black" />
                            </button>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-mono text-sm font-bold text-black uppercase"
                                    >
                                        {{ msg.name }}
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
                                <a
                                    :href="`mailto:${msg.email}`"
                                    class="font-mono text-xs text-zinc-600 hover:underline"
                                >
                                    {{ msg.email }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span
                                class="font-mono text-xs font-bold text-zinc-500 uppercase"
                            >
                                {{ new Date(msg.created_at).toLocaleString() }}
                            </span>
                            <button
                                type="button"
                                @click="deleteMsg(msg.id)"
                                class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                                title="Delete message"
                            >
                                <Trash2 class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4
                            class="font-mono text-sm font-bold tracking-wide text-black uppercase"
                        >
                            {{ msg.subject }}
                        </h4>
                        <p
                            class="mt-2 border-l-4 border-black pl-4 font-sans text-sm leading-relaxed whitespace-pre-wrap text-zinc-700"
                        >
                            {{ msg.message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

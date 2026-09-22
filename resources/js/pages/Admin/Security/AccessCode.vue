<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Shield } from '@lucide/vue';

defineProps<{
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Access PIN Security', href: route('admin.access-code.edit') },
];

const form = useForm({
    code: '',
    code_confirmation: '',
});

const submit = () => {
    form.put(route('admin.access-code.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Access PIN Security" />

        <div
            class="flex min-h-screen max-w-xl flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div>
                <div class="mb-1 inline-block">
                    <span
                        class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                    >
                        PORTAL GATEWAY
                    </span>
                </div>
                <h1
                    class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                >
                    Secret Access PIN
                </h1>
                <p
                    class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                >
                    Update the secret 6-digit PIN required to unlock the
                    concealed admin login gate.
                </p>
            </div>

            <div
                v-if="status"
                class="border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[3px_3px_0px_0px_#000]"
            >
                [OK] {{ status }}
            </div>

            <form
                @submit.prevent="submit"
                class="space-y-6 border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] sm:p-8"
            >
                <div
                    class="flex items-center gap-3 border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000]"
                >
                    <Shield class="h-5 w-5 shrink-0 text-black" />
                    <span>
                        This PIN is required before the login form can be
                        unlocked. Keep it secret.
                    </span>
                </div>

                <div>
                    <label
                        for="code"
                        class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                    >
                        New 6-Digit PIN
                    </label>
                    <input
                        id="code"
                        type="password"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        v-model="form.code"
                        required
                        placeholder="&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full border-2 border-black bg-white p-3 text-center font-mono text-xl font-bold tracking-widest text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                    />
                    <InputError :message="form.errors.code" class="mt-1" />
                </div>

                <div>
                    <label
                        for="code_confirmation"
                        class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                    >
                        Confirm New 6-Digit PIN
                    </label>
                    <input
                        id="code_confirmation"
                        type="password"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        v-model="form.code_confirmation"
                        required
                        placeholder="&bull;&bull;&bull;&bull;&bull;&bull;"
                        class="w-full border-2 border-black bg-white p-3 text-center font-mono text-xl font-bold tracking-widest text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                    />
                    <InputError
                        :message="form.errors.code_confirmation"
                        class="mt-1"
                    />
                </div>

                <div class="flex justify-end border-t-2 border-black pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing || form.code.length !== 6"
                        class="border-2 border-black bg-black px-6 py-3 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none disabled:opacity-50"
                    >
                        {{
                            form.processing
                                ? 'UPDATING...'
                                : 'UPDATE SECRET PIN'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

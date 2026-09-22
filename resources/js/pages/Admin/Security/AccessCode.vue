<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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

        <div class="flex max-w-xl flex-1 flex-col gap-6 p-6">
            <div>
                <h1
                    class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                >
                    Secret Access Code PIN
                </h1>
                <p class="mt-1 text-sm text-zinc-500">
                    Update the secret 6-digit PIN required to unlock the
                    concealed admin login gate.
                </p>
            </div>

            <div
                v-if="status"
                class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-500"
            >
                {{ status }}
            </div>

            <form
                @submit.prevent="submit"
                class="space-y-6 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
            >
                <div
                    class="flex items-center gap-3 rounded-lg bg-zinc-50 p-4 text-xs text-zinc-600 dark:bg-zinc-800/50 dark:text-zinc-300"
                >
                    <Shield class="h-5 w-5 shrink-0 text-emerald-500" />
                    <span>
                        This PIN is required before the login form can be
                        rendered. Keep it secret and never share it publicly.
                    </span>
                </div>

                <div class="space-y-2">
                    <Label for="code">New 6-Digit PIN</Label>
                    <Input
                        id="code"
                        type="password"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        v-model="form.code"
                        required
                        placeholder="e.g. 749210"
                    />
                    <InputError :message="form.errors.code" />
                </div>

                <div class="space-y-2">
                    <Label for="code_confirmation">Confirm New PIN</Label>
                    <Input
                        id="code_confirmation"
                        type="password"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        v-model="form.code_confirmation"
                        required
                        placeholder="Repeat 6-digit PIN"
                    />
                    <InputError :message="form.errors.code_confirmation" />
                </div>

                <div class="flex justify-end">
                    <Button
                        type="submit"
                        :disabled="form.processing || form.code.length !== 6"
                    >
                        {{
                            form.processing
                                ? 'Updating...'
                                : 'Update Secret PIN'
                        }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    token: string;
}>();

const form = useForm({
    token: props.token,
    code: '',
    code_confirmation: '',
});

const submit = () => {
    form.post(route('access-gate.update'), {
        onFinish: () => {
            form.reset('code', 'code_confirmation');
        },
    });
};
</script>

<template>
    <AuthLayout
        title="Define New Access PIN"
        description="Enter a new 6-digit PIN to secure your admin portal access."
    >
        <Head title="Reset Access PIN" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-2">
                <Label for="code">New 6-Digit PIN</Label>
                <Input
                    id="code"
                    type="password"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    v-model="form.code"
                    required
                    autofocus
                    placeholder="e.g. 849201"
                />
                <InputError :message="form.errors.code" />
            </div>

            <div class="grid gap-2">
                <Label for="code_confirmation">Confirm 6-Digit PIN</Label>
                <Input
                    id="code_confirmation"
                    type="password"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    v-model="form.code_confirmation"
                    required
                    placeholder="Repeat your 6-digit PIN"
                />
                <InputError :message="form.errors.code_confirmation" />
            </div>

            <Button
                type="submit"
                class="w-full"
                :disabled="form.processing || form.code.length !== 6"
            >
                {{ form.processing ? 'Updating...' : 'Save New PIN' }}
            </Button>
        </form>
    </AuthLayout>
</template>

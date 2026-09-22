<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from '@/components/ui/input-otp';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    status?: string;
}>();

const form = useForm({
    code: '',
});

const forgotForm = useForm({});
const showForgotConfirmation = ref(false);

const submit = () => {
    form.post(route('access-gate.verify'), {
        onFinish: () => {
            if (form.errors.code) {
                form.code = '';
            }
        },
    });
};

const triggerForgot = () => {
    forgotForm.post(route('access-gate.forgot'), {
        onSuccess: () => {
            showForgotConfirmation.value = true;
        },
    });
};
</script>

<template>
    <AuthLayout
        title="Admin Verification Gate"
        description="Enter your secret 6-digit PIN to access the administration portal."
    >
        <Head title="Access Verification Gate" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-emerald-500 dark:text-emerald-400"
        >
            {{ status }}
        </div>

        <div
            v-if="($page.props.errors as any)?.reset"
            class="mb-4 text-center text-sm font-medium text-rose-500"
        >
            {{ ($page.props.errors as any)?.reset }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col items-center gap-6">
            <div class="flex flex-col items-center gap-2">
                <InputOTP
                    v-model="form.code"
                    :maxlength="6"
                    :disabled="form.processing"
                    autofocus
                >
                    <InputOTPGroup>
                        <InputOTPSlot :index="0" />
                        <InputOTPSlot :index="1" />
                        <InputOTPSlot :index="2" />
                        <InputOTPSlot :index="3" />
                        <InputOTPSlot :index="4" />
                        <InputOTPSlot :index="5" />
                    </InputOTPGroup>
                </InputOTP>
                <InputError :message="form.errors.code" />
            </div>

            <Button
                type="submit"
                class="w-full"
                :disabled="form.processing || form.code.length !== 6"
            >
                {{ form.processing ? 'Verifying...' : 'Unlock Portal' }}
            </Button>
        </form>

        <div class="mt-6 text-center">
            <button
                type="button"
                @click="triggerForgot"
                :disabled="forgotForm.processing"
                class="text-xs text-muted-foreground underline-offset-4 hover:text-foreground hover:underline"
            >
                {{
                    forgotForm.processing
                        ? 'Dispatching reset link...'
                        : 'Forgot or change secret PIN?'
                }}
            </button>
        </div>
    </AuthLayout>
</template>

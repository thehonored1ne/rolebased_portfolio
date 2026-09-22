<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineOptions({
    layout: {
        title: 'Registration Disabled',
        description:
            'Public registration is disabled for this single-admin portfolio.',
    },
});
</script>

<template>
    <AuthLayout
        title="Registration Disabled"
        description="Public registration is disabled. This portfolio is operated solely by the designated administrator."
    >
        <Head title="Registration Disabled" />

        <div class="flex flex-col items-center gap-4 text-center">
            <p class="text-sm text-muted-foreground">
                If you are a guest exploring this portfolio, please visit the
                showcase page or get in touch via the contact form.
            </p>

            <Button as-child class="w-full">
                <Link :href="route('home')"> Return to Portfolio </Link>
            </Button>
        </div>
    </AuthLayout>
</template>

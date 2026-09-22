<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

interface Profile {
    id: number;
    name: string;
    title: string;
    bio: string | null;
    avatar_url: string | null;
    resume_url: string | null;
    contact_email: string | null;
    location: string | null;
    github_url: string | null;
    linkedin_url: string | null;
    twitter_url: string | null;
    is_available: boolean;
}

const props = defineProps<{
    profile: Profile;
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Profile & Hero Editor', href: route('admin.profile.edit') },
];

const form = useForm({
    name: props.profile.name ?? '',
    title: props.profile.title ?? '',
    bio: props.profile.bio ?? '',
    avatar_url: props.profile.avatar_url ?? '',
    resume_url: props.profile.resume_url ?? '',
    contact_email: props.profile.contact_email ?? '',
    location: props.profile.location ?? '',
    github_url: props.profile.github_url ?? '',
    linkedin_url: props.profile.linkedin_url ?? '',
    twitter_url: props.profile.twitter_url ?? '',
    is_available: props.profile.is_available,
});

const submit = () => {
    form.put(route('admin.profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Edit Profile & Hero" />

        <div class="flex max-w-4xl flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Portfolio Profile & Hero Content
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500">
                        Update your public persona, bio, social connections, and
                        availability status.
                    </p>
                </div>
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
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="name">Display Name</Label>
                        <Input id="name" v-model="form.name" required />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="space-y-2">
                        <Label for="title">Headline / Job Title</Label>
                        <Input id="title" v-model="form.title" required />
                        <InputError :message="form.errors.title" />
                    </div>
                </div>

                <div class="space-y-2">
                    <Label for="bio">Bio & Statement</Label>
                    <textarea
                        id="bio"
                        v-model="form.bio"
                        rows="4"
                        class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none"
                    ></textarea>
                    <InputError :message="form.errors.bio" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="space-y-2">
                        <Label for="contact_email">Public Contact Email</Label>
                        <Input
                            id="contact_email"
                            type="email"
                            v-model="form.contact_email"
                        />
                        <InputError :message="form.errors.contact_email" />
                    </div>

                    <div class="space-y-2">
                        <Label for="location">Location</Label>
                        <Input id="location" v-model="form.location" />
                        <InputError :message="form.errors.location" />
                    </div>

                    <div class="space-y-2">
                        <Label for="resume_url">Resume Download URL</Label>
                        <Input id="resume_url" v-model="form.resume_url" />
                        <InputError :message="form.errors.resume_url" />
                    </div>
                </div>

                <div class="border-t border-zinc-200 pt-6 dark:border-zinc-800">
                    <h2
                        class="text-sm font-semibold text-zinc-900 dark:text-white"
                    >
                        Social Profiles
                    </h2>
                    <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div class="space-y-2">
                            <Label for="github_url">GitHub URL</Label>
                            <Input
                                id="github_url"
                                v-model="form.github_url"
                                placeholder="https://github.com/..."
                            />
                            <InputError :message="form.errors.github_url" />
                        </div>

                        <div class="space-y-2">
                            <Label for="linkedin_url">LinkedIn URL</Label>
                            <Input
                                id="linkedin_url"
                                v-model="form.linkedin_url"
                                placeholder="https://linkedin.com/in/..."
                            />
                            <InputError :message="form.errors.linkedin_url" />
                        </div>

                        <div class="space-y-2">
                            <Label for="twitter_url">Twitter / X URL</Label>
                            <Input
                                id="twitter_url"
                                v-model="form.twitter_url"
                                placeholder="https://x.com/..."
                            />
                            <InputError :message="form.errors.twitter_url" />
                        </div>
                    </div>
                </div>

                <div class="border-t border-zinc-200 pt-6 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <input
                            type="checkbox"
                            id="is_available"
                            v-model="form.is_available"
                            class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500"
                        />
                        <Label for="is_available" class="cursor-pointer">
                            Available for new engineering opportunities (shows
                            green indicator on guest page)
                        </Label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <Button type="submit" :disabled="form.processing">
                        {{
                            form.processing
                                ? 'Saving changes...'
                                : 'Save Profile Changes'
                        }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

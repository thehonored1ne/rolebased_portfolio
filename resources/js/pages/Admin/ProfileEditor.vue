<script setup lang="ts">
import InputError from '@/components/InputError.vue';
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

        <div
            class="flex min-h-screen w-full flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div>
                <div class="mb-1 inline-block">
                    <span
                        class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                    >
                        CMS IDENTITY
                    </span>
                </div>
                <h1
                    class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                >
                    Profile & Hero Content
                </h1>
                <p
                    class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                >
                    Update public bio, contact anchors, social links, and
                    availability status.
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
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label
                            for="name"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Display Name
                        </label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError :message="form.errors.name" class="mt-1" />
                    </div>

                    <div>
                        <label
                            for="title"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Headline / Job Title
                        </label>
                        <input
                            id="title"
                            type="text"
                            v-model="form.title"
                            required
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError :message="form.errors.title" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label
                        for="bio"
                        class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                    >
                        Bio & Public Statement
                    </label>
                    <textarea
                        id="bio"
                        v-model="form.bio"
                        rows="4"
                        class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                    ></textarea>
                    <InputError :message="form.errors.bio" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label
                            for="contact_email"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Public Contact Email
                        </label>
                        <input
                            id="contact_email"
                            type="email"
                            v-model="form.contact_email"
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError
                            :message="form.errors.contact_email"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <label
                            for="location"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Location / Base
                        </label>
                        <input
                            id="location"
                            type="text"
                            v-model="form.location"
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError
                            :message="form.errors.location"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <label
                            for="resume_url"
                            class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                        >
                            Resume Download Link
                        </label>
                        <input
                            id="resume_url"
                            type="text"
                            v-model="form.resume_url"
                            class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                        />
                        <InputError
                            :message="form.errors.resume_url"
                            class="mt-1"
                        />
                    </div>
                </div>

                <div class="border-t-2 border-black pt-6">
                    <h2
                        class="mb-4 font-mono text-xs font-bold tracking-wider text-black uppercase"
                    >
                        Social Profiles & Links
                    </h2>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div>
                            <label
                                for="github_url"
                                class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-zinc-700 uppercase"
                            >
                                GitHub URL
                            </label>
                            <input
                                id="github_url"
                                type="text"
                                v-model="form.github_url"
                                placeholder="https://github.com/..."
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.github_url"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="linkedin_url"
                                class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-zinc-700 uppercase"
                            >
                                LinkedIn URL
                            </label>
                            <input
                                id="linkedin_url"
                                type="text"
                                v-model="form.linkedin_url"
                                placeholder="https://linkedin.com/in/..."
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.linkedin_url"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="twitter_url"
                                class="mb-1.5 block font-mono text-xs font-bold tracking-wider text-zinc-700 uppercase"
                            >
                                Twitter / X URL
                            </label>
                            <input
                                id="twitter_url"
                                type="text"
                                v-model="form.twitter_url"
                                placeholder="https://x.com/..."
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.twitter_url"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-black pt-6">
                    <div class="flex items-center gap-3">
                        <input
                            type="checkbox"
                            id="is_available"
                            v-model="form.is_available"
                            class="h-5 w-5 border-2 border-black bg-white text-black focus:ring-0"
                        />
                        <label
                            for="is_available"
                            class="cursor-pointer font-mono text-xs font-bold text-black uppercase"
                        >
                            Available for new engineering opportunities (shows
                            status on public portfolio)
                        </label>
                    </div>
                </div>

                <div class="flex justify-end border-t-2 border-black pt-4">
                    <button
                        type="submit"
                        class="border-2 border-black bg-black px-6 py-3 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing
                                ? 'SAVING CHANGES...'
                                : 'SAVE PROFILE CHANGES'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Plus, Trash2, X } from '@lucide/vue';
import { ref } from 'vue';

interface Experience {
    id: number;
    role: string;
    company: string;
    period: string;
    description: string;
    sort_order: number;
}

const props = defineProps<{
    experiences: Experience[];
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Experience Timeline', href: route('admin.experiences.index') },
];

const showModal = ref(false);
const editingExp = ref<Experience | null>(null);

const form = useForm({
    role: '',
    company: '',
    period: '',
    description: '',
    sort_order: 0,
});

const openCreateModal = () => {
    editingExp.value = null;
    form.reset();
    form.clearErrors();
    showModal.value = true;
};

const openEditModal = (exp: Experience) => {
    editingExp.value = exp;
    form.clearErrors();
    form.role = exp.role;
    form.company = exp.company;
    form.period = exp.period;
    form.description = exp.description;
    form.sort_order = exp.sort_order;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingExp.value = null;
};

const saveExperience = () => {
    if (editingExp.value) {
        router.put(
            route('admin.experiences.update', editingExp.value.id),
            form.data(),
            {
                onSuccess: () => closeModal(),
            },
        );
    } else {
        router.post(route('admin.experiences.store'), form.data(), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteExperience = (id: number) => {
    if (confirm('Delete this career milestone?')) {
        router.delete(route('admin.experiences.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Experience Manager" />

        <div class="flex max-w-4xl flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Work Experience Timeline
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500">
                        Document your roles, responsibilities, and key
                        achievements.
                    </p>
                </div>

                <Button @click="openCreateModal" class="gap-2">
                    <Plus class="h-4 w-4" />
                    Add Milestone
                </Button>
            </div>

            <div
                v-if="status"
                class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-500"
            >
                {{ status }}
            </div>

            <div class="space-y-4">
                <div
                    v-for="exp in experiences"
                    :key="exp.id"
                    class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-2"
                    >
                        <div>
                            <h3
                                class="text-base font-bold text-zinc-900 dark:text-white"
                            >
                                {{ exp.role }}
                            </h3>
                            <p
                                class="text-xs font-semibold text-emerald-600 dark:text-emerald-400"
                            >
                                {{ exp.company }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="rounded bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300"
                            >
                                {{ exp.period }}
                            </span>

                            <button
                                type="button"
                                @click="openEditModal(exp)"
                                class="text-xs font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                @click="deleteExperience(exp.id)"
                                class="text-xs font-semibold text-rose-500 hover:text-rose-600"
                            >
                                Delete
                            </button>
                        </div>
                    </div>

                    <p
                        class="mt-3 text-xs leading-relaxed text-zinc-600 dark:text-zinc-400"
                    >
                        {{ exp.description }}
                    </p>
                </div>
            </div>

            <!-- Modal for Create / Edit -->
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            >
                <div
                    class="w-full max-w-lg rounded-xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div
                        class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800"
                    >
                        <h2
                            class="text-lg font-bold text-zinc-900 dark:text-white"
                        >
                            {{
                                editingExp
                                    ? 'Edit Experience'
                                    : 'New Experience'
                            }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-white"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form
                        @submit.prevent="saveExperience"
                        class="mt-4 space-y-4"
                    >
                        <div class="space-y-1">
                            <Label for="exp_role">Role / Title</Label>
                            <Input
                                id="exp_role"
                                v-model="form.role"
                                required
                                placeholder="e.g. Lead Software Engineer"
                            />
                            <InputError :message="form.errors.role" />
                        </div>

                        <div class="space-y-1">
                            <Label for="exp_company"
                                >Company / Organization</Label
                            >
                            <Input
                                id="exp_company"
                                v-model="form.company"
                                required
                                placeholder="e.g. Acme Inc."
                            />
                            <InputError :message="form.errors.company" />
                        </div>

                        <div class="space-y-1">
                            <Label for="exp_period">Timeframe / Period</Label>
                            <Input
                                id="exp_period"
                                v-model="form.period"
                                required
                                placeholder="e.g. 2023 - Present"
                            />
                            <InputError :message="form.errors.period" />
                        </div>

                        <div class="space-y-1">
                            <Label for="exp_desc"
                                >Description & Achievements</Label
                            >
                            <textarea
                                id="exp_desc"
                                v-model="form.description"
                                rows="3"
                                required
                                class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm"
                            ></textarea>
                            <InputError :message="form.errors.description" />
                        </div>

                        <div
                            class="flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800"
                        >
                            <Button
                                type="button"
                                variant="outline"
                                @click="closeModal"
                                >Cancel</Button
                            >
                            <Button type="submit">Save Experience</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

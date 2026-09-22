<script setup lang="ts">
import InputError from '@/components/InputError.vue';
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

        <div
            class="flex min-h-screen w-full flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
            >
                <div>
                    <div class="mb-1 inline-block">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                        >
                            TRACK RECORD
                        </span>
                    </div>
                    <h1
                        class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                    >
                        Work Experience Timeline
                    </h1>
                    <p
                        class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                    >
                        Document career roles, achievements, and impact across
                        organizations.
                    </p>
                </div>

                <button
                    type="button"
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 border-2 border-black bg-black px-4 py-2.5 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                >
                    <Plus class="h-4 w-4" />
                    Add Milestone
                </button>
            </div>

            <div
                v-if="status"
                class="border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[3px_3px_0px_0px_#000]"
            >
                [OK] {{ status }}
            </div>

            <div class="space-y-6">
                <div
                    v-for="(exp, index) in experiences"
                    :key="exp.id"
                    class="border-2 border-black bg-white p-6 shadow-[5px_5px_0px_0px_#000] transition-all hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[7px_7px_0px_0px_#000]"
                >
                    <div
                        class="flex flex-wrap items-center justify-between gap-3"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="border-2 border-black bg-black px-2 py-0.5 font-mono text-xs font-bold text-white shadow-[2px_2px_0px_0px_#000]"
                            >
                                0{{ index + 1 }}
                            </span>
                            <div>
                                <h3
                                    class="text-xl font-black tracking-tight text-black uppercase"
                                >
                                    {{ exp.role }}
                                </h3>
                                <p
                                    class="font-mono text-xs font-bold text-zinc-600 uppercase"
                                >
                                    @ {{ exp.company }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span
                                class="border-2 border-black bg-zinc-100 px-3 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000]"
                            >
                                {{ exp.period }}
                            </span>

                            <button
                                type="button"
                                @click="openEditModal(exp)"
                                class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                @click="deleteExperience(exp.id)"
                                class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                            >
                                Delete
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 border-t-2 border-zinc-200 pt-4">
                        <p
                            class="font-sans text-sm leading-relaxed font-medium text-zinc-700"
                        >
                            {{ exp.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal for Create / Edit -->
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            >
                <div
                    class="w-full max-w-lg border-2 border-black bg-white p-6 shadow-[8px_8px_0px_0px_#000] sm:p-8"
                >
                    <div
                        class="flex items-center justify-between border-b-2 border-black pb-4"
                    >
                        <h2
                            class="text-xl font-black tracking-tight text-black uppercase"
                        >
                            {{
                                editingExp ? 'Edit Milestone' : 'New Milestone'
                            }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>

                    <form
                        @submit.prevent="saveExperience"
                        class="mt-6 space-y-4"
                    >
                        <div>
                            <label
                                for="exp_role"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Role / Title
                            </label>
                            <input
                                id="exp_role"
                                type="text"
                                v-model="form.role"
                                required
                                placeholder="e.g. Lead Software Engineer"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.role"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="exp_company"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Company / Organization
                            </label>
                            <input
                                id="exp_company"
                                type="text"
                                v-model="form.company"
                                required
                                placeholder="e.g. Acme Inc."
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.company"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="exp_period"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Timeframe / Period
                            </label>
                            <input
                                id="exp_period"
                                type="text"
                                v-model="form.period"
                                required
                                placeholder="e.g. 2023 - Present"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.period"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="exp_desc"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Description & Key Accomplishments
                            </label>
                            <textarea
                                id="exp_desc"
                                v-model="form.description"
                                rows="3"
                                required
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            ></textarea>
                            <InputError
                                :message="form.errors.description"
                                class="mt-1"
                            />
                        </div>

                        <div
                            class="flex justify-end gap-3 border-t-2 border-black pt-4"
                        >
                            <button
                                type="button"
                                @click="closeModal"
                                class="border-2 border-black bg-white px-4 py-2 font-mono text-xs font-bold tracking-wider text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="border-2 border-black bg-black px-5 py-2 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-900"
                            >
                                Save Experience
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

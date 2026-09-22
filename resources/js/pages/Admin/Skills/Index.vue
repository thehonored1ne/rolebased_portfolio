<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Plus, Trash2, X } from '@lucide/vue';
import { ref } from 'vue';

interface Skill {
    id: number;
    name: string;
    category: string;
    icon: string | null;
    proficiency: number;
    sort_order: number;
}

const props = defineProps<{
    skills: Skill[];
    status?: string;
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: route('dashboard') },
    { title: 'Skills & Stack', href: route('admin.skills.index') },
];

const showModal = ref(false);
const editingSkill = ref<Skill | null>(null);

const form = useForm({
    name: '',
    category: 'Frontend',
    icon: '',
    proficiency: 85,
    sort_order: 0,
});

const openCreateModal = () => {
    editingSkill.value = null;
    form.reset();
    form.category = 'Frontend';
    form.proficiency = 85;
    form.clearErrors();
    showModal.value = true;
};

const openEditModal = (skill: Skill) => {
    editingSkill.value = skill;
    form.clearErrors();
    form.name = skill.name;
    form.category = skill.category;
    form.icon = skill.icon ?? '';
    form.proficiency = skill.proficiency;
    form.sort_order = skill.sort_order;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingSkill.value = null;
};

const saveSkill = () => {
    if (editingSkill.value) {
        router.put(
            route('admin.skills.update', editingSkill.value.id),
            form.data(),
            {
                onSuccess: () => closeModal(),
            },
        );
    } else {
        router.post(route('admin.skills.store'), form.data(), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteSkill = (id: number) => {
    if (confirm('Delete this skill?')) {
        router.delete(route('admin.skills.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Skills Manager" />

        <div
            class="flex min-h-screen max-w-5xl flex-1 flex-col gap-6 bg-[#fafafa] p-6 text-black"
        >
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
            >
                <div>
                    <div class="mb-1 inline-block">
                        <span
                            class="border border-black bg-black px-2 py-0.5 font-mono text-[10px] font-bold text-white uppercase shadow-[1px_1px_0px_0px_#000]"
                        >
                            CAPABILITIES
                        </span>
                    </div>
                    <h1
                        class="text-3xl font-black tracking-tight text-black uppercase sm:text-4xl"
                    >
                        Skills & Technologies
                    </h1>
                    <p
                        class="mt-1 font-mono text-xs font-bold text-zinc-600 uppercase"
                    >
                        Manage categorized skills, frameworks, and proficiencies
                        shown on portfolio.
                    </p>
                </div>

                <button
                    type="button"
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 border-2 border-black bg-black px-4 py-2.5 font-mono text-xs font-bold tracking-wider text-white uppercase shadow-[3px_3px_0px_0px_#000] transition-all hover:translate-x-[-1px] hover:translate-y-[-1px] hover:bg-zinc-900 hover:shadow-[5px_5px_0px_0px_#000] active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                >
                    <Plus class="h-4 w-4" />
                    New Skill
                </button>
            </div>

            <div
                v-if="status"
                class="border-2 border-black bg-zinc-100 p-4 font-mono text-xs font-bold text-black uppercase shadow-[3px_3px_0px_0px_#000]"
            >
                [OK] {{ status }}
            </div>

            <div
                class="overflow-x-auto border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]"
            >
                <table class="w-full text-left font-sans text-sm">
                    <thead
                        class="border-b-2 border-black bg-[#fafafa] font-mono text-xs font-bold text-black uppercase"
                    >
                        <tr>
                            <th class="p-4">Technology</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Proficiency</th>
                            <th class="p-4">Order</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        <tr
                            v-for="skill in skills"
                            :key="skill.id"
                            class="transition-colors hover:bg-zinc-50"
                        >
                            <td
                                class="p-4 font-mono text-sm font-bold text-black uppercase"
                            >
                                {{ skill.name }}
                            </td>
                            <td class="p-4">
                                <span
                                    class="border border-black bg-zinc-100 px-2.5 py-1 font-mono text-[10px] font-bold text-black uppercase"
                                >
                                    {{ skill.category }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-3 w-28 border-2 border-black bg-zinc-100 p-0.5"
                                    >
                                        <div
                                            class="h-full bg-black transition-all duration-300"
                                            :style="{
                                                width: `${skill.proficiency}%`,
                                            }"
                                        />
                                    </div>
                                    <span
                                        class="font-mono text-xs font-bold text-black"
                                    >
                                        {{ skill.proficiency }}%
                                    </span>
                                </div>
                            </td>
                            <td
                                class="p-4 font-mono text-xs font-bold text-zinc-600"
                            >
                                {{ skill.sort_order }}
                            </td>
                            <td class="p-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2"
                                >
                                    <button
                                        type="button"
                                        @click="openEditModal(skill)"
                                        class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        @click="deleteSkill(skill.id)"
                                        class="border-2 border-black bg-white px-2.5 py-1 font-mono text-xs font-bold text-black uppercase shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal for Create / Edit -->
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            >
                <div
                    class="w-full max-w-md border-2 border-black bg-white p-6 shadow-[8px_8px_0px_0px_#000] sm:p-8"
                >
                    <div
                        class="flex items-center justify-between border-b-2 border-black pb-4"
                    >
                        <h2
                            class="text-xl font-black tracking-tight text-black uppercase"
                        >
                            {{ editingSkill ? 'Edit Skill' : 'New Skill' }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="flex h-8 w-8 items-center justify-center border-2 border-black bg-white text-black shadow-[2px_2px_0px_0px_#000] transition-all hover:bg-zinc-100 active:translate-x-[1px] active:translate-y-[1px] active:shadow-none"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>

                    <form @submit.prevent="saveSkill" class="mt-6 space-y-4">
                        <div>
                            <label
                                for="skill_name"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Skill / Tool Name
                            </label>
                            <input
                                id="skill_name"
                                type="text"
                                v-model="form.name"
                                required
                                placeholder="e.g. TypeScript"
                                class="w-full border-2 border-black bg-white p-3 font-sans text-sm text-black transition-shadow placeholder:text-zinc-400 focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            />
                            <InputError
                                :message="form.errors.name"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                for="skill_cat"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Category
                            </label>
                            <select
                                id="skill_cat"
                                v-model="form.category"
                                class="w-full border-2 border-black bg-white p-3 font-mono text-xs font-bold text-black uppercase focus:shadow-[4px_4px_0px_0px_#000] focus:outline-none"
                            >
                                <option value="Frontend">Frontend</option>
                                <option value="Backend">Backend</option>
                                <option value="DevOps">DevOps</option>
                                <option value="Tools">Tools</option>
                                <option value="Other">Other</option>
                            </select>
                            <InputError
                                :message="form.errors.category"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <div
                                class="mb-1 flex justify-between font-mono text-xs font-bold text-black uppercase"
                            >
                                <label for="skill_prof">Proficiency</label>
                                <span>{{ form.proficiency }}%</span>
                            </div>
                            <input
                                type="range"
                                id="skill_prof"
                                min="10"
                                max="100"
                                v-model.number="form.proficiency"
                                class="w-full cursor-pointer accent-black"
                            />
                        </div>

                        <div>
                            <label
                                for="skill_order"
                                class="mb-1 block font-mono text-xs font-bold tracking-wider text-black uppercase"
                            >
                                Sort Order
                            </label>
                            <input
                                id="skill_order"
                                type="number"
                                v-model.number="form.sort_order"
                                class="w-full border-2 border-black bg-white p-2.5 font-mono text-xs font-bold text-black focus:outline-none"
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
                                Save Skill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

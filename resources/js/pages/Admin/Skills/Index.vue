<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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

        <div class="flex max-w-5xl flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        Skills & Technologies
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500">
                        Manage categorized skills, frameworks, and proficiencies
                        shown on your portfolio.
                    </p>
                </div>

                <Button @click="openCreateModal" class="gap-2">
                    <Plus class="h-4 w-4" />
                    New Skill
                </Button>
            </div>

            <div
                v-if="status"
                class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-500"
            >
                {{ status }}
            </div>

            <div
                class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
            >
                <table class="w-full text-left text-sm">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 text-xs text-zinc-500 uppercase dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400"
                    >
                        <tr>
                            <th class="p-4">Technology</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Proficiency</th>
                            <th class="p-4">Order</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-zinc-200 dark:divide-zinc-800"
                    >
                        <tr
                            v-for="skill in skills"
                            :key="skill.id"
                            class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/40"
                        >
                            <td
                                class="p-4 font-semibold text-zinc-900 dark:text-white"
                            >
                                {{ skill.name }}
                            </td>
                            <td class="p-4">
                                <span
                                    class="rounded bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300"
                                >
                                    {{ skill.category }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-1.5 w-24 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800"
                                    >
                                        <div
                                            class="h-full bg-emerald-500"
                                            :style="{
                                                width: `${skill.proficiency}%`,
                                            }"
                                        />
                                    </div>
                                    <span class="text-xs text-zinc-500"
                                        >{{ skill.proficiency }}%</span
                                    >
                                </div>
                            </td>
                            <td class="p-4 text-xs text-zinc-500">
                                {{ skill.sort_order }}
                            </td>
                            <td class="p-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-3"
                                >
                                    <button
                                        type="button"
                                        @click="openEditModal(skill)"
                                        class="text-xs font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        @click="deleteSkill(skill.id)"
                                        class="text-xs font-semibold text-rose-500 hover:text-rose-600"
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
                    class="w-full max-w-md rounded-xl border border-zinc-200 bg-white p-6 shadow-2xl dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div
                        class="flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800"
                    >
                        <h2
                            class="text-lg font-bold text-zinc-900 dark:text-white"
                        >
                            {{ editingSkill ? 'Edit Skill' : 'New Skill' }}
                        </h2>
                        <button
                            type="button"
                            @click="closeModal"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-white"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form @submit.prevent="saveSkill" class="mt-4 space-y-4">
                        <div class="space-y-1">
                            <Label for="skill_name"
                                >Skill / Framework Name</Label
                            >
                            <Input
                                id="skill_name"
                                v-model="form.name"
                                required
                                placeholder="e.g. Vue 3"
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="space-y-1">
                            <Label for="skill_cat">Category</Label>
                            <select
                                id="skill_cat"
                                v-model="form.category"
                                class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm"
                            >
                                <option value="Frontend">Frontend</option>
                                <option value="Backend">Backend</option>
                                <option value="DevOps">DevOps</option>
                                <option value="Tools">Tools</option>
                                <option value="Other">Other</option>
                            </select>
                            <InputError :message="form.errors.category" />
                        </div>

                        <div class="space-y-1">
                            <Label for="skill_prof"
                                >Proficiency ({{ form.proficiency }}%)</Label
                            >
                            <input
                                type="range"
                                id="skill_prof"
                                min="10"
                                max="100"
                                v-model.number="form.proficiency"
                                class="w-full"
                            />
                        </div>

                        <div class="space-y-1">
                            <Label for="skill_order">Sort Order</Label>
                            <Input
                                id="skill_order"
                                type="number"
                                v-model.number="form.sort_order"
                            />
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
                            <Button type="submit">Save Skill</Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const page = usePage();
const appName = computed(() => {
    const raw = page.props.name;
    return !raw || raw === 'Laravel' ? 'Portfolio CMS' : raw;
});
</script>

<template>
    <div
        class="flex aspect-square size-7 shrink-0 items-center justify-center border-2 border-black bg-black text-white shadow-[1.5px_1.5px_0px_0px_#000]"
    >
        <AppLogoIcon class="size-4 fill-current text-white" />
    </div>
    <div
        class="ml-2 flex flex-col text-left group-data-[collapsible=icon]:hidden"
    >
        <span
            class="font-mono text-xs font-black tracking-wider text-black uppercase"
        >
            {{ appName }}
        </span>
        <span
            class="font-mono text-[9px] font-bold tracking-widest text-zinc-500 uppercase"
        >
            Admin Portal
        </span>
    </div>
</template>

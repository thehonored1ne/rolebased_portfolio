<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { Toaster } from '@/components/ui/sonner';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent
            variant="sidebar"
            class="min-h-screen min-w-0 flex-1 overflow-x-clip bg-[#fafafa] text-black"
        >
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <div class="min-h-full w-full flex-1 bg-[#fafafa] text-black">
                <slot />
            </div>
        </AppContent>
        <Toaster />
    </AppShell>
</template>

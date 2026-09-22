<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel
            class="font-mono text-[10px] font-bold tracking-widest text-zinc-500 uppercase"
            >CMS Controls</SidebarGroupLabel
        >
        <SidebarMenu class="mt-1 space-y-1">
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                    class="border-2 border-transparent font-mono text-xs font-bold tracking-wider uppercase transition-all hover:bg-zinc-100 hover:text-black data-[active=true]:border-2 data-[active=true]:border-black data-[active=true]:bg-black data-[active=true]:text-white data-[active=true]:shadow-[2px_2px_0px_0px_#000]"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" class="h-4 w-4" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

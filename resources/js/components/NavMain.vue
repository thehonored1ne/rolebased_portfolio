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
            class="font-mono text-[10px] font-bold tracking-widest text-black uppercase"
            >CMS Controls</SidebarGroupLabel
        >
        <SidebarMenu class="mt-1 space-y-1">
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                    class="border-2 font-mono text-xs font-bold tracking-wider uppercase transition-all"
                    :class="
                        isCurrentUrl(item.href)
                            ? 'border-black !bg-black !text-white shadow-[2px_2px_0px_0px_#000]'
                            : 'border-transparent bg-transparent !text-black hover:!bg-zinc-200 hover:!text-black'
                    "
                >
                    <Link
                        :href="item.href"
                        class="flex w-full items-center gap-2.5"
                        :class="
                            isCurrentUrl(item.href)
                                ? '!text-white'
                                : '!text-black'
                        "
                    >
                        <component
                            :is="item.icon"
                            class="h-4 w-4 shrink-0"
                            :class="
                                isCurrentUrl(item.href)
                                    ? '!text-white'
                                    : '!text-black'
                            "
                        />
                        <span
                            :class="
                                isCurrentUrl(item.href)
                                    ? '!text-white'
                                    : '!text-black'
                            "
                            >{{ item.title }}</span
                        >
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>

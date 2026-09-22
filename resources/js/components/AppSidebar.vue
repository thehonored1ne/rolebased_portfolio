<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Briefcase,
    Code,
    ExternalLink,
    FileEdit,
    FolderGit2,
    LayoutGrid,
    Mail,
    Shield,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'CMS Dashboard',
        href: route('dashboard'),
        icon: LayoutGrid,
    },
    {
        title: 'Profile & Bio',
        href: route('admin.profile.edit'),
        icon: FileEdit,
    },
    {
        title: 'Projects',
        href: route('admin.projects.index'),
        icon: FolderGit2,
    },
    {
        title: 'Skills & Stack',
        href: route('admin.skills.index'),
        icon: Code,
    },
    {
        title: 'Experience Timeline',
        href: route('admin.experiences.index'),
        icon: Briefcase,
    },
    {
        title: 'Messages Inbox',
        href: route('admin.messages.index'),
        icon: Mail,
    },
    {
        title: 'Access PIN Security',
        href: route('admin.access-code.edit'),
        icon: Shield,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'View Public Portfolio',
        href: route('home'),
        icon: ExternalLink,
    },
];
</script>

<template>
    <Sidebar
        collapsible="icon"
        variant="sidebar"
        class="border-r-2 border-black bg-[#fafafa]"
    >
        <SidebarHeader class="border-b-2 border-black bg-white p-3">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        size="lg"
                        as-child
                        class="border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-zinc-100"
                    >
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="bg-[#fafafa] py-3">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter class="border-t-2 border-black bg-white p-3">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

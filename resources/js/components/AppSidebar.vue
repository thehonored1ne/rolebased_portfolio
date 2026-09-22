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
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

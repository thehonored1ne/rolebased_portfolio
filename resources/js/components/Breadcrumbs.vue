<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';

type Props = {
    breadcrumbs: BreadcrumbItemType[];
};

defineProps<Props>();
</script>

<template>
    <Breadcrumb class="text-black">
        <BreadcrumbList
            class="font-mono text-xs font-bold tracking-wider text-black uppercase"
        >
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage class="font-bold text-black">{{
                            item.title
                        }}</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink
                            as-child
                            class="text-zinc-600 hover:text-black"
                        >
                            <Link :href="item.href">{{ item.title }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator
                    v-if="index !== breadcrumbs.length - 1"
                    class="font-bold text-black"
                />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

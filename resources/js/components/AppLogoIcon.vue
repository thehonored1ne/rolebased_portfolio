<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="currentColor"
        :class="className"
        v-bind="$attrs"
    >
        <path
            d="M4 4.5L12 11.5L4 18.5H7.5L15 11.5L7.5 4.5H4ZM12 16.5H21V19.5H12V16.5Z"
        />
    </svg>
</template>

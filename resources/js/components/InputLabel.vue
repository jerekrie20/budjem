<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
        <div class="flex align-top">
            <span v-if="value">{{ value }}</span>
            <span v-else><slot /></span>
            <span v-else><slot /></span><span class="block font-medium text-sm text-red-500 ml-2">required</span>
        </div>

    </label>
</template>

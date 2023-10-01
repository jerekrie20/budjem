<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['flash']);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="mt-64 bg-gray-900 flex flex-col items-center justify-center">
            <h1 class="text-5xl text-white font-bold mb-8 animate-pulse">
                Dashboard Coming Soon
            </h1>
            <p class="text-white text-lg mb-8">
                We're working hard to bring you something amazing. Stay tuned!
            </p>
        </div>

        <div class="py-12"  v-if="flash.message" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">{{flash.message}}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

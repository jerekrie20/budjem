<script setup>

import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <body style="font-family: Open Sans, sans-serif">

    <nav class="flex justify-between items-center bg-black text-white pl-24 pr-24">

        <div>
            <Link href="/">
                <ApplicationLogo class="w-1/2"/>
            </Link>
        </div>

        <div class="flex sm:justify-between sm:items-center">
            <a href="/" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 uppercase mr-4">Home</a>
            <a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 uppercase mr-4">News</a>
            <a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 uppercase mr-4">About</a>
            <a href="" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 uppercase mr-4">Contact</a>

        </div>

        <div
            class="mt-8 md:mt-0 space-x-2 flex items-center text-white"
        >
            <div v-if="canLogin" class="p-6 text-right">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
                >

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                    >

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                    >
                </template>
            </div>

            <div class="max-w-7xl mx-auto p-6 lg:p-8">

            </div>


        </div>

    </nav>

        <slot></slot>

    </body>

</template>

<style scoped>

</style>

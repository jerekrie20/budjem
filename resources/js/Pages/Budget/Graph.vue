<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddBudget from "@/Pages/Budget/Partials/AddBudget.vue";
import {Head} from '@inertiajs/vue3';
import DoughnutChart from '@/components/DoughnutChart.vue';
import NavLink from "@/Components/NavLink.vue";

defineProps({
    chartData: { type: Object },
});
</script>

<template>
    <Head title="Graph" />
    <AuthenticatedLayout>
        <template #header>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Graph <span class="ml-3">|</span> </h1>
                <NavLink :href="route('budget')" :active="route().current('budget')">
                    <span class="text-black dark:text-gray-300">Budget</span>
                </NavLink>
            </div>

        </template>


        <div class="w-full mt-4 m-auto sm:w-1/4 sm:mt-16 text-white">
            <DoughnutChart :chartData="chartData" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>

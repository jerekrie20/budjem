<script setup>

import PrimaryButton from "@/components/PrimaryButton.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {computed, ref, watch} from "vue";

//get budgets from controller
//needs to be reactive

const budgets = ref([]);

budgets.value = [...usePage().props.budgets];

watch(() => usePage().props.budgets, (newVal, oldVal) => {
    //console.log('usePage().props.budgets updated!', newVal);
    budgets.value = [...newVal];
}, {deep: true});

//calculate totalAmount from budgets
const totalAmount = computed(() => {
    return budgets.value.reduce((total, budget) => total + parseFloat(budget.amount), 0);
});

const confirmDelete = (id) => {
    if (window.confirm("Are you sure you want to delete?")) {
        window.location.href = `/budget/destroy/${id}`;
    }
};

</script>

<template>

    <!-- Using tailwind to display a list of the budgets, needs to be responsive for mobile, and set up for dark and light mode -->
    <div class="xl:flex xl:justify-center lg:m-4 text-center shadow-md bg-white dark:bg-gray-900">

        <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700 xl:w-1/2">
            <li v-for="budget in budgets" :key="budget.id"
                class="flex flex-col md:flex-row justify-between gap-x-6 py-5 ">

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Name: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{ budget.name }}</p>
                </div>

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Type: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{ budget.type }}</p>
                </div>

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Due Date: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{
                            budget.due_date
                        }}</p>
                </div>

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Amount: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">${{
                            budget.amount
                        }}</p>
                </div>

                <div class="flex-1 mb-2">
                    <span class="md:hidden font-medium mr-3 text-red-600">Frequency: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{
                            budget.frequency
                        }}</p>
                </div>

                <div class="flex-1 mb-3 md:mb-0 flex justify-center">
                    <PrimaryButton>
                        <Link :href="`/budget/show/${budget.id}`">Edit</Link>
                    </PrimaryButton>
                    <span class="ml-2 mr-2"></span>
                    <PrimaryButton @click="() => confirmDelete(budget.id)"><span
                        class="text-red-500 font-bold">Delete</span></PrimaryButton>
                </div>
            </li>
            <div class="mt-4 mb-6 p-3 bg-black dark:bg-white">
                <p class="text-2xl leading-6 text-white dark:text-green-950">TOTAL: ${{ totalAmount }}</p>
            </div>
        </ul>
    </div>


</template>

<style scoped>

</style>

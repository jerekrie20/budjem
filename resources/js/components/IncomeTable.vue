<script setup>

import PrimaryButton from "@/components/PrimaryButton.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {computed, ref, watch} from "vue";

//get budgets from controller
//needs to be reactive

const incomes = ref([]);

incomes.value = [...usePage().props.incomes];

watch(() => usePage().props.incomes, (newVal, oldVal) => {
    incomes.value = [...newVal];
}, { deep: true });

const confirmDelete = (id) => {
    if (window.confirm("Are you sure you want to delete?")) {
        window.location.href = `/income/destroy/${id}`;
    }
};
//calculate totalAmount from income
const totalAmount = computed(() => {
    return incomes.value.reduce((total, income) => total + parseFloat(income.amount), 0);
});
</script>

<template>

    <div class="xl:flex xl:justify-center lg:m-4 text-center shadow-md bg-white dark:bg-gray-900">

        <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700 xl:w-1/2">
            <li v-for="income in incomes" :key="income.id"
                class="flex flex-col md:flex-row justify-between gap-x-6 py-5 ">

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Name: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{ income.name }}</p>
                </div>

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Amount: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">${{
                            income.amount
                        }}</p>
                </div>

                <div class="flex-1">
                    <span class="md:hidden font-medium mr-3 text-red-600">Pay Date: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{
                            income.pay_date
                        }}</p>
                </div>

                <div class="flex-1 mb-2">
                    <span class="md:hidden font-medium mr-3 text-red-600">Frequency: </span>
                    <p class="inline text-sm font-semibold leading-6 text-black dark:text-white">{{
                            income.frequency
                        }}</p>
                </div>

                <div class="flex-1 mb-3 md:mb-0 flex justify-center">
                    <PrimaryButton> <Link :href="`/income/show/${income.id}`" >Edit</Link></PrimaryButton>
                    <span class="ml-2 mr-2"></span>
                    <PrimaryButton @click="() => confirmDelete(income.id)" ><span class="text-red-500 font-bold">Delete</span></PrimaryButton>
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

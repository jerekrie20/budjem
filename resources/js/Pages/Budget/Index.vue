<script setup>

// Import ref from Vue to create reactive variables
import {ref, defineProps, computed, reactive, watch} from 'vue';
import {Head, usePage,Link} from '@inertiajs/vue3';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddBudget from "@/Pages/Budget/Partials/AddBudget.vue";

import NavLink from "@/Components/NavLink.vue";
import AddIncome from "@/Pages/Budget/Partials/AddIncome.vue";
import ExpensesTable from "@/Components/ExpensesTable.vue";
import IncomeTable from "@/Components/IncomeTable.vue";

const { expense, update,budgets,incomes,incomeIn } = defineProps(['expense', 'update','budgets','incomes','incomeIn']);


const showMessage = ref(false);

const showFlashMessage = () => {
    showMessage.value = true;
    setTimeout(() => {
        showMessage.value = false;
    }, 2000);
};

</script>

<template>
    <Head title="Budget"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Budget <span
                    class="ml-3">|</span></h1>
                <NavLink :href="route('graph')" :active="route().current('graph')">
                   <span class="text-black dark:text-gray-300">Graph</span>
                </NavLink>
            </div>

        </template>


        <div v-if="showMessage" class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">{{ $page.props.flash.message }}</div>
                    </div>
                </div>
        </div>

        <div class="text-black dark:text-white text-center font-bold text-2xl mt-16">
            <h2>Income</h2>
        </div>


        <AddIncome :update="update" :incomeIn="incomeIn" @form-submitted="showFlashMessage"></AddIncome>

        <div class="text-black dark:text-white text-center font-bold text-2xl mt-16">
            <h2>Expenses</h2>
        </div>

        <AddBudget :update="update" :expense="expense" @form-submitted="showFlashMessage"></AddBudget>

        <div class="text-center text-black dark:text-white mt-16 mb-6">
            <h2 class="font-bold text-xl">Budget Details</h2>
        </div>

        <ExpensesTable :budgets="budgets"></ExpensesTable>

        <div class="text-center text-black dark:text-white mt-16 mb-6">
            <h2 class="font-bold text-xl">Income Details</h2>
        </div>

        <IncomeTable :incomes="incomes"></IncomeTable>

    </AuthenticatedLayout>
</template>

<style scoped>


</style>

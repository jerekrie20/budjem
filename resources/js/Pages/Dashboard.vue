<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {defineProps} from 'vue';
import DoughnutChart from "@/components/DoughnutChart.vue";
import BarChart from "@/components/BarChart.vue";
import Report from "@/components/Report.vue";

//import needed charts


//Pull data from Controller
const {
    flash, weeklySpent, weeklyIncome, weeklyLeft, monthlySpent, monthlyIncome, monthlyLeft,
    yearlySpent, yearlyIncome, yearlyLeft, chartData, MonthlychartData, YearlychartData
}
    = defineProps([
    'flash', 'weeklySpent', 'weeklyLeft',
    'weeklyIncome', 'monthlySpent', 'monthlyLeft',
    'monthlyIncome', 'yearlySpent', 'yearlyIncome',
    'yearlyLeft', 'chartData', 'MonthlychartData',
    'YearlychartData'
]);

//Function get current week date
const getWeekDate = (date) => {
    const day = date.getDay() || 7;
    if (day !== 1)
        date.setHours(-24 * (day - 1));
    return date;
};

//get current week date and format it to locale date string (Thursday 1, 1970)
const week = getWeekDate(new Date()).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
});
//get current month name
const month = new Date().toLocaleDateString('en-US', {
    month: 'long',
    year: 'numeric',
});
//get current year
const year = new Date().getFullYear();

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <!-- <div class="mt-20 sm:mt-40 bg-gray-900 flex flex-col items-center justify-center text-center">
             <h1 class="text-5xl text-white font-bold mb-8 animate-pulse">
                 Dashboard Coming Soon
             </h1>
             <p class="text-white text-lg mb-8">
                 We're working hard to bring you something amazing. Stay tuned!
             </p>
         </div>-->

        <div class="py-12" v-if="flash.message">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">{{ flash.message }}</div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center">

            <div class="w-full mt-4 sm:w-1/4 sm:mt-16 text-white justify-self-end m-3 ">
                <h2 class="text-center text-white text-3xl mb-3">Weekly Report</h2>
                <p class="text-center text-white text-lg font-bold">{{ week }}</p>
                <BarChart :chartData="chartData"/>
            </div>

            <div class="w-full mt-4 sm:w-1/4 sm:mt-16 text-white justify-self-start  m-3">
                <h2 class="text-center text-white text-3xl mb-3">Monthly Report</h2>
                <p class="text-center text-white text-lg font-bold">{{ month }}</p>
                <BarChart :chartData="MonthlychartData"/>
            </div>

            <div class="w-full mt-4 sm:w-1/4 sm:mt-16 text-white justify-self-start  m-3">
                <h2 class="text-center text-white text-3xl mb-3">Yearly Report</h2>
                <p class="text-center text-white text-lg font-bold">{{ year }}</p>
                <BarChart :chartData="YearlychartData"/>
            </div>

        </div>

        <div class="flex flex-col sm:flex-row justify-center mt-28">
            <Report name="Weekly Income" :amount="weeklyIncome" :color="1"></Report>
            <Report name="Weekly Spent" :amount="weeklySpent" :color="1"></Report>
            <Report name="Weekly Net" :amount="weeklyLeft" :color="1"></Report>
        </div>

        <div class="flex flex-col sm:flex-row justify-center mt-14">
            <Report name="Monthly Income" :amount="monthlyIncome" :color="2"></Report>
            <Report name="Monthly Spent" :amount="monthlySpent" :color="2"></Report>
            <Report name="Monthly Net" :amount="monthlyLeft" :color="2"></Report>
        </div>

        <div class="flex flex-col sm:flex-row justify-center mt-14">
            <Report name="Yearly Income" :amount="yearlyIncome" :color="3"></Report>
            <Report name="Yearly Spent" :amount="yearlySpent" :color="3"></Report>
            <Report name="Yearly Net" :amount="yearlyLeft" :color="3"></Report>
        </div>




    </AuthenticatedLayout>
</template>

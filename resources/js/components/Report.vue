<script setup>
import { ref, onMounted, watch, defineProps } from 'vue';

//props name, amount
const props = defineProps(['name', 'amount', 'color']);

//set different gradients for each category
const gradient = ref(null);
const gradientColors = [
    {
        start: '#2c3e50',
        end: '#fd746c',
    },
    {
        start: '#0b486b',
        end: '#f56217',
    },
    {
        start: '#2c3e50',
        end: '#4ca1af',
    }
];

//pick a gradient base on color number
const pickGradient = (color) => {
    switch (color) {
        case 1:
            return gradientColors[0];
        case 2:
            return gradientColors[1];
        case 3:
            return gradientColors[2];
        default:
            return gradientColors[0];
    }
};

//set gradient
onMounted(() => {
    gradient.value = pickGradient(props.color);
});

//add gradient to div
const gradientStyle = ref(null);
watch(gradient, () => {
    gradientStyle.value = `background: linear-gradient(90deg, ${gradient.value.start} 0%, ${gradient.value.end} 100%);`;
});

</script>

<template>

    <div class="relative flex flex-col items-center rounded-[10px] border-[1px] border-gray-200 w-full sm:w-1/6 m-4 p-4 bg-white bg-clip-border shadow-md shadow-[#F3F3F3] dark:border-[#ffffff33] dark:!bg-navy-800 dark:text-white dark:shadow-none">
        <div class="relative flex mb-20 w-full justify-center rounded-xl bg-cover" >
            <div class="absolute flex h-32 w-full justify-center rounded-xl bg-cover" :style="gradientStyle">

            </div>
        </div>
        <div class="mt-16 flex flex-col items-center">
            <h4 class="text-xl font-bold text-navy-700 dark:text-black">
                {{ name }}
            </h4>
        </div>
        <div class="mt-6 mb-3 flex gap-14 md:!gap-14">
            <div class="flex flex-col items-center justify-center">
                <p class="text-2xl font-bold text-navy-700 dark:text-black">${{amount}}</p>
                <p class="text-sm font-normal text-black">Total</p>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, DoughnutController, ArcElement, Title, Tooltip, Legend } from 'chart.js';

const chartRef = ref(null);
const props = defineProps(['chartData']);

const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            labels: {
                color: 'white', // Sets the color of the label text
                font: {
                    size: 16, // Sets the font size
                    family: 'Arial', // Sets the font family
                    style: 'bold', // Sets the font style
                },
            },
        },
    },
};


let myChart;

onMounted(() => {
    Chart.register(DoughnutController, ArcElement, Title, Tooltip, Legend);
    const ctx = chartRef.value.getContext('2d');
    myChart = new Chart(ctx, {
        type: 'doughnut',
        data: props.chartData,
        options: chartOptions, // Use the customized options
    });
});

// Watch for changes in chartData prop and update the chart accordingly
watch(
    () => props.chartData,
    (newChartData) => {
        if (myChart) {
            myChart.data = newChartData;
            myChart.update();
        }
    },
    { deep: true }
);
</script>

<template>
    <div>
        <canvas ref="chartRef"></canvas>
    </div>
</template>

<style scoped>
canvas {
    width: 100%;
    height: 400px;
}
</style>

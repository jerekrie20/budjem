<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, BarController, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend } from 'chart.js';

const chartRef = ref(null);
const props = defineProps(['chartData']);

const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: false,
            labels: {
                color: 'white',
                font: {
                    size: 16,
                    family: 'Arial',
                },
            },
        },
    },
    scales: {
        x: {
            type: 'category',
            grid: {
                display: true,
                color: 'white',
                z: -1,
            },
            ticks: {
                color: 'white',
                font: {
                    size: 16,
                    family: 'Arial',
                },
            },
        },
        y: {
            type: 'linear',
            grid: {
                borderDash: [3, 3],
                color: 'white',
                z: -1,
            },
            beginAtZero: true,
            ticks: {
                color: 'white',
                font: {
                    size: 16,
                    family: 'Arial',
                },
                // Include $ in front of the numbers
                callback: function(value, index, values) {
                    return '$' + value;
                }
            },
        }
    }
};

let myChart;

onMounted(() => {
    Chart.register(BarController, BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend);
    const ctx = chartRef.value.getContext('2d');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: props.chartData,
        options: chartOptions,
    });
});

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

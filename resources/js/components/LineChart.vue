<template>
    <Line :data="chartData" :options="chartOptions" />
</template>

<script lang="ts">
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js'
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend)

export default {
    name: 'LineChart',
    components: {
        Line
    },
    props: {
        chartData: {
            type: Object,
            required: true
        },
        chartOptions: {
            type: String,
            required: true
        }
    }
}
</script>

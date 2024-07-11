<template>
    <Doughnut :data="chartData" :options="chartOptions" />
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'
ChartJS.register(ArcElement, Tooltip, Legend)

export default {
    name: 'DoughnutChart',
    components: {
        Doughnut
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

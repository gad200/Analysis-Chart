import './bootstrap';
import { createApp } from 'vue';
import vuetify from "./vuetify";
import "@mdi/font/css/materialdesignicons.css";
//components
import SideBare from './components/SideBare.vue';
import BarChart from './components/BarChart.vue';
import LineChart from './components/LineChart.vue';
import DoughnutChart from './components/DoughnutChart.vue';
import GasNotify from './components/GasNotify.vue';
//views
import DashboardView from './views/DashboardView.vue';
import AnalyticsView from './views/AnalyticsView.vue';
import ActionsView from './views/ActionsView.vue';

const app = createApp({});

app.component('SideBare', SideBare)
    .component('BarChart', BarChart)
    .component('LineChart', LineChart)
    .component('DoughnutChart', DoughnutChart)
    .component('DashboardView', DashboardView)
    .component('AnalyticsView', AnalyticsView)
    .component('ActionsView', ActionsView)
    .component('GasNotify', GasNotify);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

app.use(vuetify).mount("#app");




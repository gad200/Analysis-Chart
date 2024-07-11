<template>
    <div class="other-admins px-5 py-5 my-9 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <v-row class="d-flex justify-center">
            <v-col cols="3">
                <v-select
                    label="Select"
                    :items="dates"
                    v-model="selectedDate"
                ></v-select>
            </v-col>
            <v-col  cols="2">
                <v-btn @click="getDataAndDates(selectedDate)" style="width: 100%; background-color: #32981a; color: white;height: 55px">Search</v-btn>
            </v-col>

        </v-row>
    </div>

   <v-container floid class=" px-9 py-9 bg-white overflow-hidden shadow-sm sm:rounded-lg">

       <v-row>
           <v-col cols="6">
               Choose Chart
               <v-radio-group v-model="charts">
               <v-radio label="PH Over Time" value="phBar"></v-radio>
               <v-radio label="Temperature Over Time" value="TempBar"></v-radio>
               <v-radio label="Average of PH " value="phPie"></v-radio>
               <v-radio label="Upper and Lower values of Temperature " value="tempPie"></v-radio>
               </v-radio-group>
           </v-col>
           <v-col cols="6">
               <div v-if="charts === 'phBar'">
                   <BarChart  v-if="loaded" :chart-data="phBarData" :chart-options="phBarOptions"/>
                   {{chartDescription = "This chart Represents Ph data on the vertical line, and the date on the horsetail line"}}
               </div>
               <div v-if="charts === 'TempBar'">
                   <BarChart v-if="loaded" :chart-data="tempBarData" :chart-options="tempBarOptions"/>
                   {{ chartDescription = "This chart Represents Temperature data on the vertical line, and the date on the horsetail line" }}
               </div>
               <div v-else-if="charts === 'phPie'">
                    <DoughnutChart v-if="loaded" :chart-data="phAvgPiData" :chart-options="phAvgPiOptions" />
               </div>
               <div v-else-if="charts === 'tempPie'">
                    <DoughnutChart v-if="loaded" :chart-data="tempAvgPiData" :chart-options="tempAvgPiOptions" />
               </div>
               <div></div>
           </v-col>
       </v-row>
   </v-container>
</template>
<script>
import LineChart from "@/components/LineChart.vue";
import BarChart from "@/components/BarChart.vue";
import DoughnutChart from "@/components/DoughnutChart.vue"
import {Doughnut} from "vue-chartjs";

export default {
    data() {
        return {
            chartDescription: "DoughnutChart",

            dates: [],

            selectedDate: null,

            charts: 'Line',
            loaded: false,

            phBarData: {
                labels: [],
                datasets: [ {
                    label: 'PH Data',
                    data: [],
                    backgroundColor: [
                        '#04fc04'
                    ]
                } ]
            },
            phBarOptions: {
                responsive: true,
            },

            tempBarData: {
                labels: [],
                datasets: [ {
                    label: 'Temperature Data',
                    data: [],
                    backgroundColor: [
                        '#3d3d3d'
                    ]
                } ]
            },
            tempBarOptions: {
                responsive: true
            },

            phAvgPiData: {
                labels: ['PH'],
                datasets: [
                    {
                        backgroundColor: ['rgba(4,252,4,0.7)', 'rgba(4,252,4,0.22)'],
                        data: []
                    }
                ]
            },
            phAvgPiOptions: {
                responsive: true,
                maintainAspectRatio: false
            },

            tempAvgPiData: {
                labels: ['Upper Temp', 'Lower Temp'],
                datasets: [
                    {
                        backgroundColor: ['#3d3d3d', 'rgba(61,61,61,0.34)'],
                        data: []
                    }
                ]
            },
            tempAvgPiOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    components:{
        LineChart,
        BarChart,
        DoughnutChart
    },
    methods: {
        async get_dates(day){
            // night and day selection.
            let response;
            if(day == null){
                response = await axios.get(`/get-dates`);
            }else {
               response = await axios.get(`/get-dates/${day}`);
            }

            this.dates = response.data.dates;
        },
        getDataAndDates(selected){
            // get data with today as default
            this.ph_over_time(selected);
            this.temp_over_time(selected);
            this.avg_ph(selected);
            this.avg_temp(selected);

            // recursive the get-dates function by passig to it the selected date
            this.get_dates(selected);
        },

        async ph_over_time(date){
            this.loaded = false
            let response;
            if(date == null){
                response = await axios.get(`/ph-over-time`);
            }else {
                response = await axios.get(`/ph-over-time/${date}`);
            }
            this.phBarData.labels = response.data.labels;
            this.phBarData.datasets[0].data = response.data.data;

            this.loaded = true
        },

        async temp_over_time(date){
            this.loaded = false
            let response;
            if(date == null){
                response = await axios.get(`/temp-over-time`);
            }else {
                response = await axios.get(`/temp-over-time/${date}`);
            }
            this.tempBarData.labels = response.data.labels;
            this.tempBarData.datasets[0].data = response.data.data;

            this.loaded = true
        },

        async avg_ph(date){
            this.loaded = false
            let response;
            if(date == null){
                response = await axios.get(`/avg-ph`);
            }else {
                response = await axios.get(`/avg-ph/${date}`);
            }
            this.phAvgPiData.datasets[0].data = response.data;

            this.loaded = true
        },

        async avg_temp(date){
            this.loaded = false
            let response;
            if(date == null){
                response = await axios.get(`/avg-temp`);
            }else {
                response = await axios.get(`/avg-temp/${date}`);
            }
            this.tempAvgPiData.datasets[0].data = response.data;

            this.loaded = true
        },
    },
    mounted() {
        this.get_dates();
        this.ph_over_time();
        this.temp_over_time();
        this.avg_ph();
        this.avg_temp();
    }
}

</script>

<template>
    <v-container style="height: 500px" floid class=" px-5 py-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="d-flex justify-between">
            <h1 class="" style="font-weight: bold; font-size: 35px">Real Time Data</h1>
            <iframe src="https://free.timeanddate.com/clock/i9cvc1tf/n53/tleg/fs20/ftb/bo2/pa5/th2" frameborder="0" width="128" height="35"></iframe>
        </div>

        <v-row style="height: 260px; font-size: 25px">
            <v-col cols="6" >
                <line-chart :chart-data="PHdata" :chart-options="PHoptions"></line-chart>
            </v-col>
            <v-col cols="6">
                <line-chart :chart-data="TEMPdata" :chart-options="TEMPoptions"></line-chart>
            </v-col>
        </v-row>
        <v-row class="py-10">
            <v-col cols="6">some data to clarify the sensor: sensor type + location</v-col>
            <v-col cols="6">some data to clarify the sensor: sensor type + location</v-col>
        </v-row>
    </v-container>
    <div class="other-admins px-5 py-5 my-9 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h1 class="text-center" style="font-weight: bold; font-size: 35px">Other Admins</h1>
        <v-table  style="border: 1px solid;">
            <thead>
            <tr>
                <th class="text-center" style="font-weight: bolder; font-size: 20px">
                    Name
                </th>
                <th class="text-center"style="font-weight: bolder; font-size: 20px">
                    Email
                </th>
                <th class="text-center" style="font-weight: bolder; font-size: 20px">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                style="font-size: 17px"
                v-for="(user, index) in users"
                :key="user.name"
                :class="index % 2 === 0 ? 'gray-row' : ''"
            >
                <td class="text-center">{{ user.name }}</td>
                <td class="text-center">{{ user.email }}</td>
                <td class="text-center"><v-icon>mdi-circle</v-icon></td>
            </tr>
            </tbody>
        </v-table>
    </div>
</template>
<script>
import LineChart from "@/components/LineChart.vue";
import axios from "axios";

export default{
    components: {
        LineChart,
    },
    methods: {
        formatLabels(labels) {
            let previousHour = null;
            let previousPeriod = null;
            return labels.map(dateTime => {
                const date = new Date(dateTime);
                let hour = date.getHours();
                let period = 'AM';
                if (hour >= 12) {
                    period = 'PM';
                    hour = hour === 12 ? hour : hour - 12;
                }
                if (hour === previousHour && period === previousPeriod) {
                    return `${hour}:30 ${period}`;
                }
                previousHour = hour;
                previousPeriod = period;
                return `${hour}:00 ${period}`;
            });
        },
        async getPhData() {
            let response = await axios.get('/dashData');
            this.PhLabelsData = response.data.phlabelsdata;
            this.phData = response.data.phdata;
            //console.log(PhLabelsData);
        },
    },
    data: ()=>{
        return {
            //PhLabelsData: [],
            //TempLabelsData: ['2024-4-5 9:00:00', '2024-4-5 9:30:000', '2024-4-5 10:00:000', '2024-4-5 10:30:00', '2024-4-5 11:00:00' , '2024-4-5 11:30:00'],
            //tempData: [40, 39, 70, 40, 39, 80, 40],
            //phData: [],

            PHdata: {
                labels: ['2024-4-5 9:00:00', '2024-4-5 9:30:000', '2024-4-5 10:00:000', '2024-4-5 10:30:00', '2024-4-5 11:00:00' , '2024-4-5 11:30:00'],
                datasets: [
                    {
                        label: 'PH Sensor ( Data / Time )',
                        borderColor: '#04fc04',
                        backgroundColor: 'black',
                        data: [40, 39, 70, 40, 39, 80, 40],
                    }
                ],
            },
            PHoptions: {
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 1,
                            max: 14,
                            ticks: {
                                stepSize: 2,
                            }
                        }
                    }
                }
            },
            TEMPdata: {
                labels: ['2024-4-5 9:00:00', '2024-4-5 9:30:000', '2024-4-5 10:00:000', '2024-4-5 10:30:00', '2024-4-5 11:00:00' , '2024-4-5 11:30:00'],
                datasets: [
                    {
                        label: 'Temperature Sensor ( Data / Time )',
                        backgroundColor: 'white',
                        borderColor: 'black',
                        data: [40, 39, 70, 40, 39, 80, 40]
                    }
                ],

            },
            TEMPoptions: {
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {

                        },
                        y: {
                            min: 25,
                        }
                    }
                }
            }
        };
    },
    mounted() {
        // setInterval(()=>{
        //     axios.get('/dashData');
        // }, 3000);
        this.getPhData();
    },
}
</script>

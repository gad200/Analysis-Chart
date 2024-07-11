<template>
<!--////////////////////////////////////////////
    //// test adding new gas record ///////////
    <v-btn @click="add_gas_record()">add</v-btn>
    -->
    <v-container  floid class=" px-5 py-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="d-flex justify-between">
            <h1 class="" style="font-weight: bold; font-size: 35px">Real Time Data</h1>
            <iframe src="https://free.timeanddate.com/clock/i9cvc1tf/n53/tleg/fs20/ftb/bo2/pa5/th2" frameborder="0" width="128" height="35"></iframe>
        </div>

        <v-row style="height: 260px; font-size: 25px">
            <v-col cols="6" >
                <line-chart v-if="loaded"  :chart-data="PHdata" :chart-options="PHoptions"></line-chart>
            </v-col>
            <v-col cols="6">
                <line-chart v-if="loaded" :chart-data="TEMPdata" :chart-options="TEMPoptions"></line-chart>
            </v-col>
        </v-row>
        <v-row class="py-10">
            <v-col cols="6">some data to clarify the sensor: sensor type + location</v-col>
            <v-col cols="6">some data to clarify the sensor: sensor type + location</v-col>
        </v-row>
    </v-container>
    <div class="other-admins px-5 py-5 my-9 bg-white overflow-hidden shadow-sm sm:rounded-lg" >
        <h1 class="text-center" style="font-weight: bold; font-size: 35px">Resource Usage</h1>
        <v-row class="pt-6">
            <v-col cols="4">
                the amount of Lime water and chemicals that added to the juice
            </v-col>
            <v-col cols="8">
                <DoughnutChart :data="piData" :options="piOptions"/>
            </v-col>
        </v-row>
    </div>
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
                <td class="text-center">
                    <v-btn color="red" @click="confirmDelete(user.id)">Delete</v-btn>
                </td>
            </tr>
            </tbody>
        </v-table>
    </div>
</template>
<script>
import LineChart from "@/components/LineChart.vue";
import axios from "axios";
import {Doughnut} from "vue-chartjs";

function formatLabels(labels) {
    return labels.reverse().map(function (e) {
        let arr = e.split(' ')[1];
        let hour = parseInt(arr.split(':')[0]);
        let period = hour >= 12 ? 'PM' : 'AM';
        if (hour > 12) {
            hour -= 12;
        }
        return `${hour}:${arr.split(':')[1]} ${period}`;
    });
}

export default{
    components: {
        Doughnut,
        LineChart,
    },
    data() {
        return {
            users: [],

            loaded: false,

            PHdata: {
                labels: [],
                datasets: [
                    {
                        label: 'PH Sensor ( Data / Time )',
                        borderColor: '#04fc04',
                        backgroundColor: 'black',
                        data: [],
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
                labels: [],
                datasets: [
                    {
                        label: 'Temperature Sensor ( Data / Time )',
                        backgroundColor: 'white',
                        borderColor: 'black',
                        data: []
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
            },
            piData: {
                labels: ['Lime Water', 'Empty'],
                datasets: [
                    {
                        backgroundColor: ['#41B883', 'rgba(65,184,131,0.17)'],
                        data: [40, 60]
                    }
                ]
            },
            piOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    methods: {
        async add_gas_record(){
            await axios.get('/add-gas').then(window.location.reload);
            console.log('yes')
        },
        async getData() {
            this.loaded = false
            try {
                let response = await axios.get('/dashData');
                // console.log(response);
                this.PHdata.labels = formatLabels(response.data.phlabelsdata);
                this.PHdata.datasets[0].data = response.data.phdata;
                this.TEMPdata.labels = formatLabels(response.data.templabelsdata);
                this.TEMPdata.datasets[0].data = response.data.tempdata;

                this.loaded = true
            } catch (e) {
                console.error(e)
            }
        },

        async GetUsers(){
            let res = await axios.get('/get-users');
            this.users = res.data.users;
        },

        confirmDelete(userId) {
            if (window.confirm('Are you sure you want to delete this user?')) {
                this.DeleteUser(userId);
            }
        },

        async DeleteUser(userId){
            await axios.delete(`/destroy-user/${userId}`).then(window.location.reload());
        },
    },
    mounted() {
        this.getData();
        this.GetUsers();
        window.setInterval(this.getData, 5000 );
    },

}

</script>

<template>
    <v-container floid>
        <div class="other-admins px-5 py-5 my-9 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <v-row>
                <v-col cols="2">
                    <div style="">
                        <input v-model="searchRequest.date" style="background-color: #ebebeb; padding: 15px; width: 100%; border-bottom: 1px solid #938c8c" type="date">
                    </div>
                </v-col>
                <v-col cols="3">
                    <v-text-field v-model="searchRequest.ph"
                                  label="PH sensor"
                                  :error-messages="phErrors"
                                  @input="validatePh"
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field v-model="searchRequest.temp"
                                  label="Temperature sensor"
                                  :error-messages="tempErrors"
                                  @input="validateTemp"
                    ></v-text-field>
                </v-col>
                <v-col cols="2">
                    <v-select
                        v-model="searchRequest.action"
                        label="Action"
                        :items="['Add', 'No']"
                    ></v-select>
                </v-col>
                <v-col cols="2">
                        <v-btn style="width: 100%; background-color: #32981a; color: white;height: 55px" @click="search(searchRequest)"  :disabled="!isFormValid">Search</v-btn>
                </v-col>

            </v-row>
        </div>
        <v-table class=" table other-admins px-5 py-5 my-9 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <thead>
            <tr>
                <th class="text-center">
                    PH Sensor
                </th>
                <th class="text-center">
                    Temperature Sensor
                </th>
                <th class="text-center">
                    Time
                </th>
                <th class="text-center">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(item, index) in data"
                :key="item.time"
                :class="index % 2 === 0 ? 'gray-row' : ''"
            >
                <td class="text-center">{{ item.ph_sensor.data }}</td>
                <td class="text-center">{{ item.temp_sensor.data }}</td>
                <td class="text-center">{{ item.created_at }}</td>
                <td :class="item.decision === 'No'? 'no text-center' : 'add text-center'">
                    {{ item.decision }}
                </td>
            </tr>
            </tbody>
        </v-table>
        <TailwindPagination :data="paginationData" @pagination-change-page="fetchData" />
    </v-container>
</template>

<script>
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    components: {
        TailwindPagination,
    },
    data: ()=>{
        return {
            paginationData: {},
            searchRequest: {
                date: '',
                ph: '',
                temp: '',
                action: ''
            },
            phErrors: [],
            tempErrors: [],
            data: []
        }
    },
    computed: {
        isFormValid() {
            return this.phErrors.length === 0 && this.tempErrors.length === 0;
        }
    },
    methods: {
        async search(request){
            let res = await axios.post('/search', request);
            this.data = res.data.data;
            this.paginationData = res.data;
        },

        async fetchData(page) {
            const response = await axios.get(`/index?page=${page}`);
            this.data = response.data.data;
            this.paginationData = response.data;
        },

        validatePh() {
            this.phErrors = [];
            const ph = parseFloat(this.searchRequest.ph);
            if (isNaN(ph) || ph < 1 || ph > 14) {
                this.phErrors.push('pH must be a number between 1 and 14.');
            }
        },
        validateTemp() {
            this.tempErrors = [];
            const temp = parseFloat(this.searchRequest.temp);
            if (isNaN(temp)) {
                this.tempErrors.push('Temperature must be a valid number.');
            }
        },
    },
    mounted() {
        this.fetchData();
    }
}
</script>
<style>
.table{
    font-size: 20px;
}
.add{
    background-color:  #32981a;
    color: white;
    padding: 10px;
}
.no{
    background-color: rgba(26, 25, 25, 0.77);
    color: white;
    padding: 10px;
}
</style>

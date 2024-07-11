<template>
    <v-alert
        :class="display"
        border="top"
        icon="mdi-alert"
        text="Their Is Gas In the Manufacture: pleas go to the /// place of sensor // and check it!"
        type="error"
    ></v-alert>
</template>
<script>
export default{
    data: ()=>{
        return{
            hidden: true,
            display: 'd-none',
        }
    },
    methods: {
        async check(){
            let response = await axios.get('/check');
            if (response.data.gase === 1){
                this.hidden = false;
                this.display = 'd-flex';
                setTimeout(() => {
                    this.hidden = true;
                    this.display = 'd-none';
                }, 60000);
                await axios.get(`/done/${response.data.id}`);
            }
        }
    },
    mounted() {
        this.check();
        window.setInterval(this.check, 60000 );
    }
}
</script>

<template>

</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return {
             num:'Ammar Ibrahim',
            } ;
        },
        methods: {
            test(){
                axios.get('/api/section/add',{params:{name:this.name,description:this.description}}).then(response =>{
                this.items = response.data;
                alert('تم اضافة البيانات');

                }).catch(error =>{
                    console.error('Error');
                });
                alert('kk');
            }
        },
        mounted() {
            console.log('Ammar->.')
        }
    }
</script>

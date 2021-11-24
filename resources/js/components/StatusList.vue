<template>
    <div @click="redirectIfGuest" class="mb-12 mt-10">
        <status-list-item v-for="status in statuses" :key="status" :status="status"></status-list-item>
    </div>
</template>


<script>
    import axios from 'axios';
    import auth from '../mixins/auth'; 
 
    export default {
        props: {
            url: String
        }, 
        mixins: [ auth ],
        data() {
            return {
                statuses: []
            }
        },
        mounted() {
            axios.get(this.getUrl)
                .then(res => {
                    this.statuses = res.data.data
                }).catch(err => {
                    console.error(err.response.data);
                });

            this.EventBus.on('status-created', status => {
                this.statuses.unshift(status);
            });

            Echo.channel('statuses').listen('StatusCreated', ({status}) => {
                this.statuses.unshift(status);
            }); 
        },
        computed: {
            getUrl() {
                return this.url ? this.url : '/statuses'; 
            }
        }
    }
</script>
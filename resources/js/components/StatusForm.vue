<template>
    <form @submit.prevent="submit" v-if="isAuthenticated">
        <div class="py-4 px-8 shadow-md rounded-lg bg-white">
            <div class="rounded-lg">
                <div class="mt-3">
                    <textarea name="body" v-model="body"
                        class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"
                        id="message" type="text" :placeholder="`What are you thinking ${ user.name }`" rows="3"
                        required></textarea>
                </div>
            </div>
            <div class="py-1">
                <button
                    class="block w-full tracking-widest uppercase text-center shadow bg-gray-700 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded"
                    id="create-status" type="submit">Send!</button>
            </div>
        </div>
    </form>

    <div v-else>
        <a href="/login"
            class="block w-full tracking-widest uppercase text-center shadow bg-gray-700 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded"
            id="create-status" type="submit">Login!</a>
    </div>
</template>

<script>
    import axios from "axios";
    import auth from "../mixins/auth";

    export default {
        data() {
            return {
                body: ''
            }
        },
        mixins: [auth],
        methods: {
            submit() {
                axios.post('/statuses', {
                        body: this.body
                    })
                    .then(res => {
                        this.EventBus.emit('status-created', res.data.data);
                        this.body = '';
                    })
                    .catch(err => {
                        console.error(err.response.data);
                    });
            }
        }
    }

</script>

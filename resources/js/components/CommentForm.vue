<template>
    <div>
        <form @submit.prevent="addComment">
            <div class="grid grid-cols-1 mt-8 w-11/12 mx-auto">
                <div class="rounded-lg">
                    <div class="grid grid-cols-1 mt-3">
                        <textarea v-model="newComment"
                            class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"
                            id="message" type="text" placeholder="Write a comment..." rows="2" required></textarea>
                    </div>
                </div>

                <div class="py-1">
                    <button
                        class="block w-full tracking-widest uppercase text-center shadow bg-gray-700 hover:bg-gray-900 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded mb-5"
                        id="create-status" type="submit">Send!</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            statusId: {
                Number,
                required: true
            }
        },
        data() {
            return {
                newComment: '',
            }
        },
        methods: {
            addComment() {
                axios.post(`/statuses/${this.statusId}/comments`, {
                        body: this.newComment
                    })
                    .then(res => {
                        this.newComment = '';
                        this.EventBus.emit(`statuses.${this.statusId}.comments`, res.data.data);
                    }).catch(err => {
                        console.log(err.response.data);
                    });
            }
        }
    }
</script>
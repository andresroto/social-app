<template>
    <div>
        <div v-if="localFriendshipStatus === 'pending'">
            <div
                class="flex flex-col md:flex-row md:max-w-full rounded-lg bg-white hover:bg-gray-100 border shadow-md items-center">
                <div class="p-5 flex flex-col justify-between leading-normal">
                    <h5 class="text-gray-900 font-bold text-md tracking-tight">{{ sender.name }} has sent
                        you a friend request.</h5>
                </div>
                <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:mb-4 md:mb-0">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3"
                        @click="acceptFriendshipRequest">Accept request</button>

                    <button type="button"
                        class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3"
                        @click="denyFriendshipRequest">Deny request</button>

                    <button type="button" v-if="localFriendshipStatus === 'deleted'"
                        class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 ">Delete
                        request</button>

                    <button type="button"
                        class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3"
                        v-else @click="deleteFriendship">Delete</button>
                </div>
            </div>

        </div>

        <div class="bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700 text-center"
            v-else-if="localFriendshipStatus === 'accepted'">
            <span class="bg-green-100 text-green-800 text-lg mr-2 px-2.5 py-0.5 rounded-md">You and
                <span>{{ sender.name }}</span> are friends</span>
        </div>

        <div class="bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700 text-center"
            v-else-if="localFriendshipStatus === 'denied'">
            <span class="bg-green-100 text-green-800 text-lg mr-2 px-2.5 py-0.5 rounded-md">Request denied from
                <span>{{ sender.name }}</span></span>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            sender: {
                type: Object,
                required: true
            },
            friendshipStatus: {
                type: String,
                required: false
            }
        },
        data() {
            return {
                localFriendshipStatus: this.friendshipStatus
            }
        },
        methods: {
            acceptFriendshipRequest() {
                axios.post(`/accept-friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = res.data.friendship_status;
                    })
                    .catch(err => {
                        console.error(err.response.data);
                    });
            },
            denyFriendshipRequest() {
                axios.delete(`/accept-friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = res.data.friendship_status;
                    })
                    .catch(err => {
                        console.error(err.response.data);
                    });
            },
            deleteFriendship() {
                axios.delete(`/friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = res.data.friendship_status;
                    })
                    .catch(err => {
                        console.error(err.response.data);
                    });
            }
        },
    }
</script>
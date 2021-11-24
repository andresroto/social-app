<template>
    <button class="block w-full tracking-widest uppercase text-center bg-gray-700 hover:bg-gray-900 shadow-sm focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded-sm mt-6" @click="toggleFriendshipStatus">{{  getText  }}</button>
</template>

<script>
import axios from 'axios';
import auth from '../mixins/auth';

export default {
    props: {
        recipient: {
            type: Object,
            required: true
        }, 
        friendshipStatus: {
            type: String, 
            required: true
        }
    },
    mixins: [ auth ],
    data() {
        return {
            localFriendshipStatus: this.friendshipStatus
        }
    },
    methods: {
        toggleFriendshipStatus() {

            this.redirectIfGuest(); 
            
            let method = this.getMethod(); 

            axios[method](`friendships/${this.recipient.name}`)
            .then(res => {
                this.localFriendshipStatus = res.data.friendship_status; 
            })
            .catch(err => {
                console.error(err); 
            }); 
        }, 
        getMethod() {
            if(this.localFriendshipStatus === 'pending' || this.localFriendshipStatus === 'accepted') {
                return 'delete'; 
            }

            return 'post';
        }
    },
    computed: {
        getText() {
            if(this.localFriendshipStatus === 'pending') {
                return 'Request sent'; 
            }

            if(this.localFriendshipStatus === 'accepted') {
                return 'Delete friend'; 
            }

            if(this.localFriendshipStatus === 'denied') {
                return 'Danied request'; 
            }

            return 'Send friend request'; 
        }
    }
}
</script>
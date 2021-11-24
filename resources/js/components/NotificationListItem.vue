<template>
    <div class="grid grid-cols-3 py-2">
        <a :href="notification.data.link" class="text-gray-600 hover:text-gray-900 text-xs text-center col-span-2">
           {{ notification.data.message }}
        </a>

        <div class="mx-auto">
            <button class="bg-red-700 hover:bg-red-900 text-white text-xs font-bold py-1 px-2 rounded"
                @click.stop="markAsUnread" v-if="isRead">Unread</button>
            <button class="bg-gray-700 hover:bg-gray-900 text-white text-xs font-bold py-1 px-2 rounded"
                @click.stop="markAsRead" v-else>Read</button>
        </div>
    </div>
    <hr>
</template>

<script>
    export default {
        props: {
            notification: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                isRead: !!this.notification.read_at
            }
        },
        methods: {
            markAsRead() {
                axios.post(`/read-notifications/${this.notification.id}`)
                    .then(res => {
                        this.isRead = true;
                        this.EventBus.emit('notification-read');
                    })
                    .catch(err => {
                        console.error(err);
                    })
            },
            markAsUnread() {
                axios.delete(`/read-notifications/${this.notification.id}`)
                    .then(res => {
                        this.isRead = false;
                        this.EventBus.emit('notification-unread');
                    })
                    .catch(err => {
                        console.error(err);
                    })
            }
        }
    }
</script>
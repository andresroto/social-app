<template>
    <div class="p-4">
        <notification-list-item v-for="notification in notifications" :key="notification.id"
            :notification="notification">
        </notification-list-item>
    </div>
</template>

<script>
    import auth from '../mixins/auth';
    import NotificationListItem from './NotificationListItem.vue';
    export default {
        components: {
            NotificationListItem
        },
        mixins: [auth],
        data() {
            return {
                notifications: [],
                count: ''
            }
        },
        created() {
            if (this.isAuthenticated) {
                Echo.private(`App.Models.User.${this.user.id}`)
                    .notification(notification => {
                        this.count++;
                        this.notifications.push({
                            id: notification.id,
                            data: {
                                link: notification.link,
                                message: notification.message
                            }
                        });
                    });
            }

            axios.get('/notifications')
                .then(res => {
                    this.notifications = res.data;
                    this.unreadNotifications();
                })
                .catch(err => {
                    console.error(err);
                });

            this.EventBus.on('notification-read', () => {
                if (this.count === 1) {
                    return this.count = '';
                }

                this.count--;
            });

            this.EventBus.on('notification-unread', () => {
                this.count++;
            });
        },
        methods: {
            unreadNotifications() {
                this.count = this.notifications.filter(notification => {
                    return notification.read_at === null;
                }).length || ''
            }
        }
    }

</script>

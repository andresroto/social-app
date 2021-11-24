<template>
    <comment-list-item v-for="comment in comments" :key="comment.id" :comment="comment">
    </comment-list-item>
</template>

<script>
    import CommentListItem from './CommentListItem.vue';

    export default {
        components: {
            CommentListItem
        },
        props: {
            comments: {
                type: Array,
                required: true
            },
            statusId: {
                type: Number,
                required: true
            }
        },
        mounted() {
            Echo.channel(`statuses.${this.statusId}.comments`).listen('CommentCreated', ({
                comment
            }) => {
                this.comments.push(comment);
            });

            this.EventBus.on(`statuses.${this.statusId}.comments`, comment => {
                this.comments.unshift(comment);
            });
        },

    }
</script>
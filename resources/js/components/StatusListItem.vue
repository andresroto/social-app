<template>
    <div class="mb-10">
        <div class="antialiased mx-auto max-w-screen-sm">
            <div class="space-y-4">
                <div class="flex">
                    <div class="flex-shrink-0 mr-3">
                        <img class="mt-2 rounded-full w-10 h-12 sm:w-12 sm:h-12" :alt="status.user.name"
                            :src="status.user.avatar">
                    </div>
                    <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed shadow-lg bg-white">
                        <strong><a class="text-md" :href="status.user.link">{{ status.user.name }}</a></strong>
                        <span class="text-xs text-gray-400 ml-2">{{ status.ago }}</span>
                        <p class="text-md">
                            {{ status.body }}
                        </p>

                        <div class="my-5 text-left">
                            <like-btn :model="status" :url="`/statuses/${status.id}/likes`"></like-btn>
                            <span class="ml-4 mb-4 text-gray-700"><i class="far fa-thumbs-up"></i> {{ status.likes_count }}</span>
                        </div>

                        <comment-list :comments="status.comments" :status-id="status.id"></comment-list>

                        <comment-form v-if="isAuthenticated" :status-id="status.id"></comment-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LikeBtn from './LikeBtn.vue';
    import CommentList from './CommentList.vue';
    import CommentForm from './CommentForm.vue';
    import auth from '../mixins/auth';

    export default {
        components: {
            LikeBtn,
            CommentList,
            CommentForm
        },
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        mixins: [auth],
        mounted() {
            Echo.channel(`statuses.${this.status.id}.likes`)
                .listen('ModelLiked', e => {
                    this.status.likes_count++;
                });

            Echo.channel(`statuses.${this.status.id}.likes`)
                .listen('ModelUnliked', e => {
                    this.status.likes_count--;
                });
        }
    }

</script>

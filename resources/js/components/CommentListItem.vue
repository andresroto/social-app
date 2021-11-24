<template>
    <div class="space-y-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0 mr-3">
                <img class="mt-3 rounded-full w-6 h-6 sm:w-8 sm:h-8" :src="comment.user.avatar"
                    :alt="comment.user.name">
            </div>
            <div class="flex-1 bg-gray-100 rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                <strong><a :href="comment.user.link">{{ comment.user.name }}</a></strong>
                <span class="text-xs text-gray-400 ml-2">{{ comment.ago }}</span>
                <p class="text-xs sm:text-sm">
                    {{ comment.body }}
                </p>

                <div class="my-4 text-right" :id="`comment-${comment.id}`">
                    <like-btn :model="comment" :url="`/comments/${comment.id}/likes`"></like-btn>
                    <span class="ml-4 text-gray-700"><i class="far fa-thumbs-up"></i> {{ comment.likes_count }} </span>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
    import LikeBtn from './LikeBtn.vue';

    export default {
        components: {
            LikeBtn
        },
        props: {
            comment: {
                type: Object,
                required: true
            }
        },
        mounted() {
            Echo.channel(`comments.${this.comment.id}.likes`)
                .listen('ModelLiked', e => {
                    this.comment.likes_count++;
                });

            Echo.channel(`comments.${this.comment.id}.likes`)
                .listen('ModelUnliked', e => {
                    this.comment.likes_count--;
                });

        }
    }

</script>

<style>
    .highlight {
        background-color: #ececec;
        padding: 10px;
        border-left: 4px solid #ff8d00;
    }

</style>

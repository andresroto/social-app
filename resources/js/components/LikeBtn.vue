<template>
    <button @click="toggle()">
        <span :class="getBtnClasses"><i :class="getIconClasses"></i> {{ getText }} </span>
    </button>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            model: {
                type: Object,
                required: true
            },
            url: {
                type: String,
                required: true
            }
        },
        methods: {
            toggle() {
                let method = this.model.is_liked ? 'delete' : 'post';
                axios[method](this.url)
                    .then(res => {
                        this.model.is_liked = !this.model.is_liked;
                        this.model.likes_count = res.data.likes_count;
                    }).catch(err => console.log(err));
            }
        },
        computed: {
            getText() {
                return this.model.is_liked ? 'I like' : 'Like';
            },
            getBtnClasses() {
                return [
                    this.model.is_liked ? 'text-gray-900' : 'text-gray-700'
                ];
            },
            getIconClasses() {
                return [
                    this.model.is_liked ? 'fas' : 'far',
                    'fa-thumbs-up'
                ];
            }
        }
    }
</script>
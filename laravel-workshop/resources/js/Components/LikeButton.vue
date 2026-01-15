<script setup>
import HeartIcon from './Icons/HeartIcon.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object
});

const form = useForm({});

function toggleLike() {
    if (props.post.has_liked) {
        form.post(route('posts.unlike', [props.post.profile, props.post]));
    } else {
        form.post(route('posts.like', [props.post.profile, props.post]));
    }
}
</script>

<template>
    <div class="flex items-center gap-1">
        <button @click.prevent="toggleLike" aria-label="Like"
            :class="post.has_liked ? 'hover:text-pixl text-pixl' : ''" data-test="like-post-button">
            <HeartIcon />
        </button>

        <span data-test="like-post-count" :class="post.has_liked ? 'hover:text-pixl text-pixl' : ''"
            class="text-sm">
            {{ post.likes_count }}
        </span>
    </div>
</template>
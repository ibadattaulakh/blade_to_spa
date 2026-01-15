<script setup>
import AppFooter from '../../Components/AppFooter.vue';
import BackIcon from '../../Components/Icons/BackIcon.vue';
import Post from '../../Components/Post.vue';
import ProfileHeader from '../../Components/ProfileHeader.vue';
import Layout from '../../Layouts/Layout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    profile: Object,
    posts: Array
});
</script>

<template>
    <Layout>
        <main class="-mx-4 flex grow flex-col gap-4 overflow-y-auto px-4 py-4">
            <Link :href="route('posts.index')" class="group flex items-baseline gap-1.5">
                <BackIcon />
                <span>back</span>
            </Link>

            <ProfileHeader :profile="profile" />

            <ol class="border-pixl-light/10 border-t pt-4">
                <Post v-for="post in posts" :key="post.id" :post="post" :show-engagement="true" data-test="post-feed-item" />
            </ol>

            <AppFooter />
        </main>
    </Layout>
</template>
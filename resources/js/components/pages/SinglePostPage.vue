<template>
  <div id="single-post">
    <h2>Dettaglio post: </h2>
    <LoaderApp v-if="isLoading"/>
    <PostCard v-else-if="!isLoading && post" :post="post" />
  </div>
</template>

<script>
import PostCard from '../posts/PostCard.vue';
import LoaderApp from '../LoaderApp.vue';
export default {
    name: "SinglePostPage",
    data() {
        return {
            post: null, 
            isLoading: false,
        };
    },
    methods: {
        fetchPost() {
            this.isLoading = true;
            axios.get("http://localhost:8000/api/posts/" + this.$route.params.slug)
                .then(res => {
                this.post = res.data;
            })
                .catch((err) => {
                console.error(err);
            })
                .then(() => {
                    this.isLoading = false;
            });
        }
    },
    mounted() {
        this.fetchPost();
    },
    components: { PostCard, LoaderApp }
}
</script>

<style>

</style>
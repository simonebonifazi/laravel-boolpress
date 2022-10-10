<template>
    <div class="content">
       <HeaderApp :title="title"/>
       <main class="container my-4">
        <router-view></router-view>
       </main>
    </div>
</template>

<script>
    import HeaderApp from './HeaderApp';
   
    export default {
        name: "App",
    data() {
        return {
            title: "Boolpress",
        };
    },
        components: {
    HeaderApp,
},
    };
</script>
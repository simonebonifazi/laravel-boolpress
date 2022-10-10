<template>
   <header class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{ title }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <router-link class="nav-link" :to="{ name: 'home'}">Home </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'contacts'}">Contacts</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'about'}">About us</router-link>
                    </li>
                    
                </ul>
            </div>
        </nav>
   </header>
</template>

<script>


export default {
    name: "HeaderApp",
    props: {
        title: String,
    }
}
</script>

<style>

</style>
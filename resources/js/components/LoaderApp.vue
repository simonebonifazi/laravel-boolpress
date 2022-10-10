<template>
    <div class="loader-overlay ">

        <div class="spinner-border text-success" role="status"></div>
    </div>
</template>

<script>
export default {
name: 'LoaderApp'
}
</script>

<style scoped>
.loader-overlay{
    top:0;
    right:0;
    left:0;
    bottom:0;
    position: fixed;
    z-index: 10;
    background-color: rgb(179, 177, 177);

    display: flex;
    align-items: center;
    justify-content: center;
    
}
.spinner-border{
    width: 175px;
    height: 175px;
}
</style>
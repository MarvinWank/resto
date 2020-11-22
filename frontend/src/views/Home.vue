<template>
    <div class="container-fluid">
        <div class="homescreen-header">
            <p class="homescreen-headline">resto</p>
        </div>
    </div>
</template>

<script>


export default {
    name: "Home",

    comments : {
    },

    mounted() {
        if (!this.$store.getters.isLoggedin) {
            this.$router.push('/login')
        }
    }
}
</script>

<style scoped>
    .homescreen-header{
        width: 100%;
        height: 5rem;
        text-align: center;
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: center;
        border-bottom: 1px solid #d9d6d6;
    }
    .homescreen-headline{
        margin: 0;
        font-size: 3rem;
        color: #3D9128;
    }

</style>

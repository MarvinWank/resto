<template>
    <div class="container-fluid">
        <RestoHeader />
        <div class="col-12">
            <RecipeOverview/>
        </div>
    </div>
</template>

<script>


import RecipeOverview from "@/views/home/RecipeOverview";
import RestoHeader from "@/components/RestoHeader";
export default {
    name: "Home",
    components: {
        RestoHeader,
        RecipeOverview
    },

    mounted() {
        if (!this.$store.getters.isLoggedin) {
            this.$router.push('/login')
        }
    }
}
</script>

<style scoped>


</style>

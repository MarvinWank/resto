<template>
    <div class="container-fluid">
        <RestoHeader />
        <div class="col-12 mt-3">
            <div class="row mb-3">
                <div class="text-center">Rezeptvorschläge</div>
            </div>
            <RecipeOverview/>
        </div>
    </div>
</template>

<script lang="ts">


import RecipeOverview from "@/views/home/RecipeOverview.vue";
import RestoHeader from "../../components/RestoHeader.vue";
import { Component, Vue } from 'vue-property-decorator'

@Component({
    components: {
        RestoHeader: RestoHeader,
        RecipeOverview: RecipeOverview
    }
})
export default class Home extends Vue{
    mounted() {
        if (!this.$store.getters.isLoggedin) {
            this.$router.push('/login')
        }
    }
}
</script>

<style scoped>


</style>

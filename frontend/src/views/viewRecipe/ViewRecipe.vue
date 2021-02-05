<template>
    <div class="container-fluid">
        <RestoHeader/>
        <div class="col-12 mt-3">

            <div class="h2 text-center">{{recipe.title}}</div>

        </div>
    </div>

</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import {Recipe} from "@/types/recipe";
import api from "@/api/api";
import RestoHeader from "@/components/RestoHeader.vue";

@Component({
    components: {
        RestoHeader
    }
})
export default class ViewRecipe extends Vue {

    private myRecipe: Recipe = {
        id: -1,
        cuisine: "deutsch",
        dietStyle: "alles",
        ingredients: [],
        timeToCook: 0,
        totalTime: 0,
        title: "",
        description: ""
    };

     created() {
        api.getRecipeById(Number(this.$route.params.id)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe(){
         return this.myRecipe;
    }


}
</script>

<style scoped>

</style>

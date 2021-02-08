<template>
    <div class="container-fluid">
        <RestoHeader/>

        <div class="h3 mt-4">{{ recipe.title }}</div>

        <div class="row">
            <div v-for="(ingredient, key) in recipe.ingredients" :key="key" class="col-12">
                -  {{ingredient.amount}}{{ingredient.unit}} {{ingredient.name}}
            </div>
        </div>

        <div class="h3 mt-4">
            Beschreibung
        </div>
        <p class="">
            {{recipe.description}}
        </p>

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

    get recipe() {
        return this.myRecipe;
    }


}
</script>

<style scoped>

</style>

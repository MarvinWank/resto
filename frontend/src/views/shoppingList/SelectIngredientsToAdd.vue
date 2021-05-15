<template>
<div class="row">
    <div v-for="(ingredient, id) in recipe.ingredients" :key="id" class="col-12">
        {{ingredient.amount}}{{ingredient.unit}} {{ingredient.name}}
    </div>
</div>

</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import api from "@/api/api";
import {Recipe} from "@/types/recipe";

@Component
export default class SelectIngredientsToAdd extends  Vue{

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
        api.getRecipeById(Number(this.$route.params.recipeId)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe() {
        return this.myRecipe;
    }
}

</script>

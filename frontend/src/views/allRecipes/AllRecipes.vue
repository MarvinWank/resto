<template>
    <div class="col-12 px-2">
        <div class="row">
            <div v-for="(recipe, id) in allRecipes" :key="id" class="col-12 col-md-6">
                <div class="recipe-card-wrapper">
                    <RecipeCard
                        :recipe="recipe"
                        :index="id"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import RecipeCard from "@/views/home/items/RecipeCard.vue";
import api from "@/api/api";
import {Recipe} from "@/types/recipe";

@Component({
    components: {
        RecipeCard
    }
})

export default class AllRecipes extends Vue {

    allRecipes: Array<Recipe> = [];

    created(){
        api.allRecipes().then(response => {
            this.allRecipes = response.recipes;
        })
    }

}
</script>

<template>
    <div class="row mt-3">
        <div class="col-12">
            <autocomplete
                placeholder="Rezept suchen"
                :search="search"
                @submit="displayRecipe"
            >

            </autocomplete>
        </div>
    </div>

</template>

<script lang="ts">

import Vue from "vue"
import Component from "vue-class-component";
// No types available
/* eslint-disable */
// @ts-ignore
import Autocomplete from '@trevoreyre/autocomplete-vue';
import '@trevoreyre/autocomplete-vue/dist/style.css'
import api from "@/api/api";
import {Recipe} from "@/types/value";

@Component({
    components: {
        Autocomplete
    }
})
export default class SearchBar extends Vue {

    recipes: Array<Recipe> = [];

    search(input: string) {
        if (input.length < 1) {
            return []
        }

        return api.saytSearch(input).then(response => {
            let result: Array<string> = [];
            this.recipes = response.recipes;

            this.recipes.forEach(recipe => {
                result.push(recipe.title);
            })

            return result;
        });
    }

    displayRecipe(recipeTitle: string){
        const recipe: Recipe | undefined = this.recipes.find(recipe => recipe.title === recipeTitle);

        if (recipe === undefined){
            console.error("Error in recipe filtering", recipeTitle,  recipe, this.recipes)
            return;
        }

        this.$router.push("/recipe/view/" + recipe.id)
    }

}
</script>

<style scoped>

</style>

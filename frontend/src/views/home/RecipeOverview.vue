<template>
    <div class="row">

        <div class="col-12">
            <div class="row">
                <div v-for="(recipe, id) in topRecipes" :key="id" class="col-12 col-md-6">
                    <div class="recipe-card-wrapper">
                        <RecipeCard
                            :recipe="recipe"
                            :index="id"
                        />
                    </div>
                </div>
            </div>
        </div>

        <router-link class="col-12 add-recipe" to="recipe/add">
            <div class="mt-4">Rezept hinzufügen +</div>
        </router-link>

    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Recipe} from "@/types/recipe";
import RecipeCard from "@/views/home/items/RecipeCard.vue";
@Component({
    components: {RecipeCard}
})
export default class RecipeOverview extends Vue{

    get topRecipes(): Array<Recipe>{
        return this.$store.getters.topRecipes;
    }

}
</script>

<style scoped lang="scss">


</style>

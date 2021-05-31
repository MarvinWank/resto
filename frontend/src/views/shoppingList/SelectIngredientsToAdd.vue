<template>
    <div class="">

        <h3 class="color-grey-darker">Zutaten zu Einkaufsliste hinzufügen</h3>

        <FormulateInput
            v-model="allChecked"
            type="checkbox"
            label="alle aus/abwählen"
            class="ingredients-select-all"
        />

        <FormulateInput
            v-model="checkedIngredients"
            :options="ingredientOptions"
            type="checkbox"
            class="ingredients-list"
        />

        <button class="mt-5 btn btn-primary btn-block"
                @click="addToShoppingList"
        >
            Auf die Einkaufsliste setzen
        </button>
    </div>


</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import api from "@/api/api";
import {Recipe} from "@/types/recipe";
import {Watch} from "vue-property-decorator";
import {IngredientsSet} from "@/types/value";

@Component
export default class SelectIngredientsToAdd extends Vue {

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

    checkedIngredients: Array<string> = [];
    private allChecked = false;

    created() {
        api.getRecipeById(Number(this.$route.params.recipeId)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe() {
        return this.myRecipe;
    }

    get ingredientOptions() {
        const ingredients: Array<string> = [];

        this.recipe.ingredients.forEach(ingredient => {
            ingredients.push(ingredient.name);
        })

        return ingredients;
    }

    @Watch('allChecked')
    checkAll() {

        if (this.allChecked) {
            this.recipe.ingredients.forEach(ingredient => {
                this.checkedIngredients.push(ingredient.amount + ingredient.unit + ' ' + ingredient.name);
            })
        } else {
            this.checkedIngredients = [];
        }
    }

    addToShoppingList() {
        const ingredients = this.recipe.ingredients.filter(ingredient => {
            return this.checkedIngredients.includes(ingredient.name)
        })

        this.$store.commit("addIngredientToShoppingList", ingredients);
        this.$router.push({name: 'ViewShoppingList'});
    }
}

</script>

<style scoped lang="scss">

</style>

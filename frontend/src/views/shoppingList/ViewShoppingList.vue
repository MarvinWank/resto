<template>

    <div>
        <h3 class="color-grey-darker">Einkaufsliste</h3>

        <div class="row mt-3 mb-4">
            <div class="col-12 col-md-9">
                <FormulateInput
                    v-model="name"
                    placeholder="Name der Zutat"
                    type="text"
                    class="input"
                />
            </div>
            <div class="col-12 col-md-3">
                <div class="btn btn-primary">
                    Hinzufügen
                </div>
            </div>
        </div>

        <FormulateInput
            v-model="checkedIngredients"
            :options="ingredientOptions"
            type="checkbox"
            class="ingredients-list"
        />

    </div>

</template>


<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import {Ingredient} from "@/types/value";

@Component
export default class ViewShoppingList extends Vue {

    checkedIngredients: Array<string> = [];

    get ingredientOptions() {
        const ingredients: Array<string> = [];

        this.$store.getters.shoppingList.ingredients.forEach((ingredient: Ingredient) => {
            ingredients.push(ingredient.amount + ingredient.unit + ' ' + ingredient.name);
        });

        return ingredients;
    }


}


</script>

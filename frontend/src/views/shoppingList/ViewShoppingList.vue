<template>

    <div>

        <h3 class="color-grey-darker">Einkaufsliste</h3>

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

@Component
export default class ViewShoppingList extends Vue {

    checkedIngredients: Array<string> = [];

    get ingredientOptions() {
        const ingredients: Array<string> = [];

        this.$store.getters.shoppingList.ingredients.forEach(ingredient => {
            ingredients.push(ingredient.name);
        });

        return ingredients;
    }


}


</script>

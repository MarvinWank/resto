<template>

    <div>
        <h3 class="color-grey-darker">Einkaufsliste</h3>

        <div class="row">
            <div class="col-6">
                <div class="btn btn-block btn-primary my-3"
                     @click="showIngredientModal = true"
                >
                    Weitere Zutat Hinzufügen
                </div>
            </div>
            <div class="col-6">
                <div class="btn btn-block btn-danger my-3"
                     @click="deleteIngredients"
                >
                    Markierte Zutaten löschen
                </div>
            </div>

        </div>

        <v-easy-dialog v-model="showIngredientModal">
            <AddIngredientModal
                @addIngredient="addIngredient"
            />
        </v-easy-dialog>

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
/* @ts-ignore */
import VEasyDialog from 'v-easy-dialog'
import Component from "vue-class-component";
import {Ingredient, IngredientsSet, ShoppingList} from "@/types/value";
import AddIngredientModal from "@/views/addRecipe/AddIngredientModal.vue";

@Component({
    components: {AddIngredientModal, VEasyDialog}
})
export default class ViewShoppingList extends Vue {

    checkedIngredients: Array<string> = [];
    showIngredientModal = false;

    get shoppingList(): ShoppingList {
        return this.$store.getters.shoppingList;
    }

    get ingredientOptions() {
        const ingredients: Array<string> = [];
        this.shoppingList.ingredients.forEach((ingredient: Ingredient) => {
            ingredients.push(this.displayIngredientData(ingredient));
        });

        return ingredients;
    }

    displayIngredientData(ingredient: Ingredient) {
        return ingredient.amount + ingredient.unit + ' ' + ingredient.name;
    }

    addIngredient(ingredient: Ingredient) {
        this.showIngredientModal = false;

        ingredient.amount = Number.parseInt((ingredient.amount.toString()));
        this.$store.commit("addIngredientToShoppingList", [ingredient])
    }

    deleteIngredients() {
        const ingredients: IngredientsSet = this.shoppingList.ingredients.filter(ingredient => {
            return this.checkedIngredients.includes(this.displayIngredientData(ingredient));
        });

        this.checkedIngredients = [];

        this.$store.commit("deleteIngredientsFromShoppingList", ingredients);
    }


}


</script>

<template>
    <div class="row">
        <div class="col-12 mb-4">
            Zutaten
        </div>

        <EditableIngredientList
            :ingredients="ingredients"
            @ingredientUpdated="updateIngredient"
            @ingredientDeleted="deleteIngredient"
        />

        <div class="col-12 mt-3">
            <div class="add-ingredient" @click="showModal">
                <div class="mt-3">Zutat hinzufügen +</div>
            </div>
        </div>

        <v-easy-dialog v-model="showDialog">
            <AddIngredientModal
                @addIngredient="addIngredient"
            />
        </v-easy-dialog>

        <div class="col-12">
            <div class="mt-3 btn btn-primary float-left"
                 @click="goBack"
            >
                Zurück
            </div>
            <div :disabled="buttonDisabled"
                 class="mt-3 btn btn-primary float-right"
                 :class="buttonDisabledClass"
                 @click="emitData"
            >
                Weiter
            </div>
        </div>
    </div>
</template>

<script lang="ts">

/* @ts-ignore */
import VEasyDialog from 'v-easy-dialog'
import AddIngredientModal from "@/views/addRecipe/AddIngredientModal.vue";
import Component from "vue-class-component";
import Vue from "vue";
import {Ingredient, Recipe} from "@/types/recipe";
import EditableIngredientList from "@/components/EditableIngredientList.vue";

@Component({
    components: {
        EditableIngredientList,
        AddIngredientModal,
        VEasyDialog
    }
})
export default class SetIngredients extends Vue {


    showDialog = false;

    get currentRecipe(): Recipe{
        return this.$store.getters.currentRecipe;
    }

    get ingredients(): Array<Ingredient>{
        return this.currentRecipe.ingredients;
    }

    get buttonDisabled() {
        return Object.keys(this.ingredients).length === 0;
    }

    get buttonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    showModal() {
        this.showDialog = true;
    }

    emitData() {
        this.$emit("goForward", this.ingredients)
    }

    goBack() {
        this.$emit("goBack", this.ingredients)
    }

    deleteIngredient(key: number) {
        const recipe = this.currentRecipe;
        recipe.ingredients.splice(key, 1);

        this.$store.commit("updateRecipe", recipe);
    }

    updateIngredient(data: { ingredient: Ingredient; id: number }) {
        const ingredient: Ingredient = data.ingredient;
        const id = data.id;
        const recipe: Recipe = this.currentRecipe;

        recipe.ingredients[id] = ingredient;
        this.$store.commit("updateRecipe", recipe);
    }

    addIngredient(ingredient: Ingredient){
        this.showDialog = false;
        //Is necessary, because the modal returns a string for whatever reason
        ingredient.amount = Number.parseInt((ingredient.amount.toString()));
        const recipe = this.currentRecipe;
        recipe.ingredients.push(ingredient);

        this.$store.commit("updateRecipe", recipe);
    }
}
</script>

<style scoped lang="scss">


</style>

<template>
    <div class="row">
        <div class="col-12 mb-4">
            Zutaten
        </div>

        <div v-for="(ingredient, key) in ingredients" :key="key" class="col-12">
            <div class="ingredient-card">
                <div class="row align-items-center h-100">
                    <div class="col-3">
                        {{ ingredient.amount }} {{ ingredient.unit }}
                    </div>
                    <div class="col-6">
                        {{ ingredient.name }}
                    </div>
                    <div class="col-3">

                    </div>
                </div>

            </div>
        </div>

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

@Component({
    components: {
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

    addIngredient(ingredient: Ingredient){
        this.showDialog = false;
        const recipe = this.currentRecipe;
        recipe.ingredients.push(ingredient);

        this.$store.commit("updateRecipe", recipe);
    }
}
</script>

<style scoped lang="scss">

.add-ingredient {
    border: 2px dashed #cbcbcb;
    text-align: center;
    height: 4rem;
    color: $grey_lighter;

    cursor: pointer;
    margin-bottom: 1rem;
}

.ingredient-card {
    border-bottom: 2px solid #e3e3e3;
    height: 3rem;
    cursor: pointer;
}


</style>

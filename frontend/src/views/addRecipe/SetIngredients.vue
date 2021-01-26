<template>
    <div class="row">
        <div class="col-12 mb-4">
            Zutaten
        </div>
        <div class="col-12 ">
            <div class="add-ingredient" @click="showModal">
                <div class="mt-3">Zutat hinzufügen +</div>
            </div>
        </div>

        <div v-for="(ingredient, key) in ingredients" :key="key" class="col-12">
            <div class="ingredient-card">
                <div class="mt-3">
                    {{ ingredient.amount }}{{ ingredient.unit }} {{ ingredient.name }}
                </div>
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
                 :class="getButtonDisabledClass"
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
import {Ingredient} from "@/types/recipe";

@Component({
    components: {
        AddIngredientModal,
        VEasyDialog
    }
})
export default class SetIngredients extends Vue {


    ingredients: Array<Ingredient> = [];
    showDialog = false;


    get buttonDisabled() {
        return Object.keys(this.ingredients).length === 0;
    }

    get isButtonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    showModal() {
        this.showDialog = true;
    }

    emitData() {
        this.$emit("ingredientsSet", this.ingredients)
    }

    goBack() {
        this.$emit("goBack", this.ingredients)
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
    border: 2px solid #e3e3e3;
    height: 4rem;
    padding-left: 1rem;
    margin-bottom: .5rem;

    cursor: pointer;
}


</style>

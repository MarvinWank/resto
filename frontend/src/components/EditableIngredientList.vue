<template>

    <div>

        <div v-for="(ingredient, key) in ingredients" :key="key" class="col-12">
            <div class="ingredient-card">
                <div class="row align-items-center h-100">
                    <div class="col-9">
                        {{ ingredient.amount }}{{ ingredient.unit }}
                        {{ ingredient.name }}
                    </div>

                    <div class="col-3 justify-content-end d-flex align-items-center">
                        <i class="las la-lg la-pencil-alt mr-2"
                           @click="editIngredient(ingredient, key)"
                        ></i>
                        <i class="las la-lg la-trash-alt"
                           @click="deleteIngredient(key)"
                        ></i>
                    </div>
                </div>
            </div>
        </div>

        <v-easy-dialog v-model="showEditIngredientModal">
            <EditIngredientModal
                :id="ingredientBeingEditedId"
                :name="currentIngredient.name"
                :amount="currentIngredient.amount"
                :unit="currentIngredient.unit"
                @addIngredient="saveIngredient"
            />
        </v-easy-dialog>

    </div>

</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import {Prop} from "vue-property-decorator";
import {IngredientsSet} from "@/types/value";
import {Ingredient} from "@/types/recipe";
/* @ts-ignore */
import VEasyDialog from 'v-easy-dialog'
import EditIngredientModal from "@/views/editRecipe/EditIngredientModal.vue";

@Component({
    components: {
        EditIngredientModal,
        VEasyDialog,
    }
})
export default class EditableIngredientList extends Vue {

    @Prop() ingredients: Array<Ingredient>;

    showEditIngredientModal = false;
    ingredientBeingEditedId = -1;
    ingredientBeingEdited: Ingredient = {
        name: "",
        amount: 0,
        unit: "g",
        kcal: null
    }

    get currentIngredient(): Ingredient {
        return this.ingredientBeingEdited;
    }

    editIngredient(ingredient: Ingredient, id: number) {
        this.ingredientBeingEdited = ingredient;
        this.ingredientBeingEditedId = id;
        this.showEditIngredientModal = true;
    }

    deleteIngredient(key: number) {
        this.$emit("ingredientDeleted", key)
    }

    saveIngredient(data: { ingredient: Ingredient; id: number }) {
        this.showEditIngredientModal = false;
        this.$emit("ingredientUpdated", data)
    }

}

</script>

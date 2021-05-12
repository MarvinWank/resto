<template>

    <div class="container-fluid">
        <RestoHeader/>


        <div class="row">
            <div class="col-12 mb-3">
                <div class="h3 mt-4"> {{ recipe.title }} bearbeiten</div>
            </div>

            <div class="col-12">
                <SetBasicRecipeData
                    mode="edit"
                />
            </div>

            <div v-for="(ingredient, key) in recipe.ingredients" :key="key" class="col-12">
                <div class="ingredient-card">
                    <div class="row align-items-center h-100">
                        <div class="col-3">
                            {{ ingredient.amount }} {{ ingredient.unit }}
                        </div>
                        <div class="col-6">
                            {{ ingredient.name }}
                        </div>
                        <div class="col-3 justify-content-end d-flex align-items-center">
                            <i class="las la-lg la-pencil-alt mr-2"
                               @click="editIngredient(ingredient, key)"
                            ></i>
                            <i class="las la-lg la-trash-alt"></i>
                        </div>
                    </div>
                </div>
            </div>


            <v-easy-dialog v-model="showIngredientModal">
                <EditIngredientModal
                    :id="ingredientBeingEditedId"
                    :name="currentIngredient.name"
                    :amount="currentIngredient.amount"
                    :unit="currentIngredient.unit"
                    @addIngredient="saveIngredient"
                />
            </v-easy-dialog>

            <div class="col-12 mt-3">
                <FormulateInput
                    type="textarea"
                    v-model="description"
                    label="Beschreibung"
                />
            </div>


            <div class="btn btn-primary btn-block mt-5 col-12"
                 @click="save"
            >
                Rezept speichern
            </div>
        </div>

    </div>

</template>

<script lang="ts">

import Vue from "vue"
import Component from "vue-class-component";
import {Ingredient, Recipe} from "@/types/recipe";
import api from "@/api/api";
import RestoHeader from "@/components/RestoHeader.vue";
import {Watch} from "vue-property-decorator";
import SetBasicRecipeData from "@/views/addRecipe/SetBasicRecipeData.vue";
/* @ts-ignore */
import VEasyDialog from 'v-easy-dialog'
import EditIngredientModal from "@/views/editRecipe/EditIngredientModal.vue";

@Component({
    components: {EditIngredientModal, SetBasicRecipeData, RestoHeader, VEasyDialog}
})
export default class EditRecipe extends Vue {

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

    ingredientBeingEditedId = -1;
    ingredientBeingEdited: Ingredient = {
        name: "",
        amount: 0,
        unit: "g",
        kcal: null
    }

    showIngredientModal = false;

    @Watch("myRecipe")
    updateRecipe() {
        this.$store.commit("updateRecipe", this.recipe);
    }

    created() {
        api.getRecipeById(Number(this.$route.params.id)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe() {
        return this.myRecipe;
    }

    get description(): string{
        return this.recipe.description
    }

    //TODO: This is ludicrously bad perfomancewise
    set description(description: string){
        const recipe = this.recipe;
        recipe.description = description;

        this.$store.commit("updateRecipe", recipe);
    }


    get currentIngredient(): Ingredient {
        return this.ingredientBeingEdited;
    }

    editIngredient(ingredient: Ingredient, id: number) {
        this.ingredientBeingEdited = ingredient;
        this.ingredientBeingEditedId = id;
        this.showIngredientModal = true;
    }

    saveIngredient(data: {ingredient: Ingredient; id: number}) {
        const ingredient: Ingredient = data.ingredient;
        const id = data.id;

        this.showIngredientModal = false;
        //Is necessary, because the modal returns a string for whatever reason
        ingredient.amount = Number.parseInt((ingredient.amount.toString()));
        const recipe = this.myRecipe;
        recipe.ingredients[id] = ingredient;
        this.$store.commit("updateRecipe", recipe);
        this.$store.commit("saveRecipe");

        this.ingredientBeingEdited = {
            name: "",
            amount: 0,
            unit: "g",
            kcal: null
        };
    }

    save() {
        this.$store.commit("saveRecipe");
    }
}

</script>

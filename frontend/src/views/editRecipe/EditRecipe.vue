<template>

    <div class="container-fluid">


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

            <div class="col-12 mt-3">
                <button class="btn btn-outline-primary btn-block"
                        @click="showAddIngredientModal = true"
                >
                    Zutat hinzufügen
                </button>
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

            <v-easy-dialog v-model="showAddIngredientModal">
                <AddIngredientModal
                    @addIngredient="addIngredient"
                />
            </v-easy-dialog>

            <div class="col-12 mt-3">
                <FormulateInput
                    type="textarea"
                    v-model="description"
                    label="Beschreibung"
                />
            </div>


            <div class="btn btn-primary btn-block mt-3" style="margin-left: 15px; margin-right: 15px"
                 @click="finishEditing"
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
import AddIngredientModal from "@/views/addRecipe/AddIngredientModal.vue";
import {currentMessage} from "@/types/app";

@Component({
    components: {AddIngredientModal, EditIngredientModal, SetBasicRecipeData, RestoHeader, VEasyDialog}
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

    showEditIngredientModal = false;
    showAddIngredientModal = false;

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

    get description(): string {
        return this.recipe.description
    }

    //TODO: This is ludicrously bad perfomancewise
    set description(description: string) {
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
        this.showEditIngredientModal = true;
    }

    deleteIngredient(key: number) {
        this.recipe.ingredients.splice(key, 1);
        this.updateRecipe();
        this.save();
    }

    addIngredient(ingredient: Ingredient) {
        this.showAddIngredientModal = false;
        //Is necessary, because the modal returns a string for whatever reason
        ingredient.amount = Number.parseInt((ingredient.amount.toString()));
        this.recipe.ingredients.push(ingredient);

        this.updateRecipe();
        this.save();
    }

    saveIngredient(data: { ingredient: Ingredient; id: number }) {
        const ingredient: Ingredient = data.ingredient;
        const id = data.id;

        this.showEditIngredientModal = false;
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

        const message: currentMessage = {
            text: 'Rezept ' + this.recipe.title + ' wurde gespeichert' ,
            type: 'success'
        }
        this.$router.push("/recipe/view/" + this.recipe?.id);
        this.$store.commit("setCurrentMessage", message);
    }

    finishEditing() {
        this.save();
        this.$router.push("/recipe/view/" + this.recipe?.id)
    }
}

</script>

<template>
    <div>
        <RestoHeader/>
        <h3 class=" mt-4">Neues Rezept anlegen</h3>
        <div class="mt-3">
            <SetBasicRecipeData
                v-if="currentStep === 1"
                @dataSet="setBasicData"
            />
            <SetIngredients
                v-if="currentStep === 2"
                @ingredientsSet="setIngredients"
                @goBack="goBack"
            />
            <SetDescription
                v-if="currentStep === 3"
                @goBack="goBack"
            />
        </div>


    </div>
</template>

<script lang="ts">
import RestoHeader from "@/components/RestoHeader.vue";
import SetBasicRecipeData from "@/views/addRecipe/SetBasicRecipeData.vue";
import SetIngredients from "@/views/addRecipe/SetIngredients.vue";
import SetDescription from "@/views/addRecipe/SetDescription.vue";
import Component from "vue-class-component";
import Vue from "vue";
import {basicDataPayload, Cuisine, dietStyle, Ingredient, Recipe} from "@/types/recipe";

@Component({
    components: {
        SetDescription,
        SetIngredients,
        SetBasicRecipeData,
        RestoHeader,
    }
})
export default class AddRecipe extends Vue {
    currentStep = 1;
    declare recipe: Recipe;

    setBasicData(payload: basicDataPayload) {
        this.recipe.title = payload.title;
        this.recipe.dietStyle = payload.dietStyle;
        this.recipe.cuisine = payload.cuisine;
        this.recipe.timeToPrepare = payload.timeToPrepare;

        this.updateRecipe();
        this.currentStep++;
    }

    setIngredients(ingredients: Array<Ingredient>) {
        this.recipe.ingredients = ingredients;

        this.updateRecipe();
        this.currentStep++;
    }

    goBack() {
        this.currentStep--;
    }

    updateRecipe(){
        this.$store.commit("updateRecipe", this.recipe);
    }

    saveRecipe(){
        this.$store.commit("saveRecipe");
    }

}
</script>

<style scoped>
.col-12 {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 0;
}
</style>

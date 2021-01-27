<template>
    <div>
        <RestoHeader/>
        <div class="mt-3">
            <SetBasicRecipeData
                v-if="currentStep === 1"
                @goForward="goForward"
            />
            <SetIngredients
                v-if="currentStep === 2"
                @goForward="goForward"
                @goBack="goBack"
            />
            <SetDescription
                v-if="currentStep === 3"
                @goBack="goBack"
                @finish="saveRecipe"
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
import {basicDataPayload, Ingredient, Recipe} from "@/types/recipe";

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

    get currentRecipe(): Recipe{
        return this.$store.getters.currentRecipe;
    }

    goForward() {
        this.currentStep++;
    }
    goBack() {
        this.currentStep--;
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

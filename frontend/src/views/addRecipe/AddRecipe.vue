<template>
    <div>
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

        <div v-if="currentRecipe.description !== '' && currentRecipe.description && !recipeAdded"
             class="mt-3 btn btn-primary btn-block"
             @click="saveRecipe"
        >
            Rezept hinzufügen
        </div>

        <div v-if="recipeAdded" class="mt-3 alert alert-success">
            Rezept "{{ recipeAddedTitle }}" erfolgreich hinzugefügt.
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
import {Recipe} from "@/types/value";

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
    recipeAdded = false;
    recipeAddedTitle = "";

    get currentRecipe(): Recipe {
        return this.$store.getters.currentRecipe;
    }

    goForward() {
        this.currentStep++;
    }

    goBack() {
        this.currentStep--;
    }

    saveRecipe() {
        this.$store.commit("addRecipe");
        this.recipeAddedTitle = this.currentRecipe.title;
        this.currentStep = 1;
        this.recipeAdded = true;
        this.$store.commit("resetCurrentRecipe");
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

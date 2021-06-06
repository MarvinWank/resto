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

        <div v-if="currentRecipe.description !== '' && currentRecipe.description"
             class="mt-3 btn btn-primary btn-block"
             @click="saveRecipe"
        >
            Rezept hinzufügen
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
import {Recipe} from "@/types/recipe";
import {currentMessage} from "@/types/app";

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

        const message: currentMessage = {
            type: "success",
            text: "Rezept erfolgreich hinzugefügt"
        }
        this.$store.commit("setCurrentMessage", message)
        this.$store.commit("resetCurrentRecipe");
        this.$router.push({name: "Home"})
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

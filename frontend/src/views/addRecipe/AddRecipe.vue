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

<script>
import RestoHeader from "@/components/RestoHeader";
import SetBasicRecipeData from "@/views/addRecipe/SetBasicRecipeData";
import SetIngredients from "@/views/addRecipe/SetIngredients";
import SetDescription from "@/views/addRecipe/SetDescription";

export default {
    name: "AddRecipe",

    components: {
        SetDescription,
        SetIngredients,
        SetBasicRecipeData,
        RestoHeader,
    },

    data() {
        return {
            currentStep: 1,

            title: "",
            dietStyle: null,
            cuisine: null,
            timeToPrepare: null,
            ingredients: {},
        }
    },



    methods: {
        setBasicData(payload){
            this.title = payload.title;
            this.dietStyle = payload.dietStyle;
            this.cuisine = payload.cuisine;
            this.timeToPrepare = payload.timeToPrepare;

            this.currentStep++;
        },
        setIngredients(ingredients){
            this.ingredients = ingredients;
            this.currentStep++;
        },
        goBack(){
            this.currentStep--;
        }
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

<template>
    <div>
        <RestoHeader/>
        <h3 class=" mt-4">Neues Rezept anlegen</h3>
        <div class="mt-5">
            <SetBasicRecipeData
                v-if="currentStep === 1"
                @dataSet="setBasicData"
            />
            <SetIngredients
                v-if="currentStep === 2"
            />
        </div>


    </div>
</template>

<script>
import RestoHeader from "@/components/RestoHeader";
import SetBasicRecipeData from "@/views/addRecipe/SetBasicRecipeData";
import SetIngredients from "@/views/addRecipe/SetIngredients";

export default {
    name: "AddRecipe",
    components: {
        SetIngredients,
        SetBasicRecipeData,
        RestoHeader,
    },

    data() {
        return {
            currentStep: 2,

            title: "",
            dietStyle: null,
            cuisine: null,
            timeToPrepare: null,
            ingredients: [],
        }
    },



    methods: {
        setBasicData(payload){
            this.title = payload.title;
            this.dietStyle = payload.dietStyle;
            this.cuisine = payload.cuisine;
            this.timeToPrepare = payload.timeToPrepare;

            this.currentStep = 2;
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

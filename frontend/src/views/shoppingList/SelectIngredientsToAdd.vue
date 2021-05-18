<template>
    <div class="row">
<!--        <div v-for="(ingredient, id) in recipe.ingredients" :key="id" class="col-12">-->
<!--            <div class="row ingredient-row">-->

<!--                <div class="col-3 ingredient-checkbox">-->
<!--                    <FormulateInput-->
<!--                        type="checkbox"-->
<!--                    />-->
<!--                </div>-->

<!--                <div class="col-9">-->
<!--                    {{ ingredient.amount }}{{ ingredient.unit }} {{ ingredient.name }}-->
<!--                </div>-->


<!--            </div>-->

<!--        </div>-->

        <FormulateInput
            :options="{first: 'First', second: 'Second', third: 'Third', fourth: 'Fourth'}"
            type="checkbox"
            label="This is a label for all the options"
        />
    </div>

</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import api from "@/api/api";
import {Recipe} from "@/types/recipe";

@Component
export default class SelectIngredientsToAdd extends Vue {

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

    created() {
        api.getRecipeById(Number(this.$route.params.recipeId)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe() {
        return this.myRecipe;
    }
}

</script>

<style scoped lang="scss">


//.ingredient-row {
//    padding-top: .7rem;
//    padding-bottom: .7rem;
//
//    border-bottom: 1px solid $grey-lighter;
//
//    .ingredient-checkbox{
//        height: 2.5rem;
//    }
//
//    .formulate-input-wrapper select, .formulate-input-wrapper input{
//        height: 1.25rem !important;
//    }
//}
</style>

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
                            ></i>
                            <i class="las la-lg la-trash-alt"></i>
                        </div>
                    </div>

                </div>
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
import {Recipe} from "@/types/recipe";
import api from "@/api/api";
import RestoHeader from "@/components/RestoHeader.vue";
import {Watch} from "vue-property-decorator";
import SetBasicRecipeData from "@/views/addRecipe/SetBasicRecipeData.vue";

@Component({
    components: {SetBasicRecipeData, RestoHeader}
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

    save(){
        this.$store.commit("addRecipe");
        this.$store.commit("resetCurrentRecipe");
    }
}

</script>

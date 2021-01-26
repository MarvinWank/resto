<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                v-model="title"
                type="text"
                label="Titel"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="dietStyle"
                :options="dietStyles"
                type="select"
                placeholder=""
                label="Ernährungsweise"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="cuisine"
                :options="cuisines"
                type="select"
                placeholder=""
                label="Küche"
            />
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="time_to_prepare">geschätzte Arbeitszeit (Minuten)</label>
                <input v-model="timeToPrepare" id="time_to_prepare" class="form-control">
            </div>
        </div>

        <div class="col-12">
            <div :disabled="buttonDisabled"
                 class="mt-3 btn btn-primary float-right"
                 :class="getButtonDisabledClass"
                 @click="save"
            >
                Weiter
            </div>
        </div>
    </div>
</template>

<script lang="ts">


import Component from "vue-class-component";
import {Cuisine, dietStyle, Recipe} from "@/types/recipe";
import Vue from "vue";

@Component
export default class SetBasicRecipeData extends Vue {

    cuisines = [
        {label: "deutsch", value: "DEUTSCH"},
        {label: "mediteran", value: "MEDITERAN"},
        {label: "asiatisch", value: "ASIATISCH"},
        {label: "amerikanisch", value: "AMERIKANISCH"},
        {label: "indisch", value: "INDISCH"},
    ];
    dietStyles = [
        {label: "alles", value: "ALLES"},
        {label: "vegetarisch", value: "VEGETARISCH"},
        {label: "vegan", value: "VEGAN"},
    ];


    get currentRecipe(): Recipe {
        return this.$store.getters.currentRecipe;
    }

    get title(): string {
        return this.currentRecipe.title;
    }

    set title(title: string) {
        const recipe = this.currentRecipe;
        recipe.title = title;

        this.save(recipe);
    }

    get timeToPrepare(): number {
        return this.currentRecipe.timeToPrepare;
    }

    set timeToPrepare(time: number) {
        const recipe = this.currentRecipe;
        recipe.timeToPrepare = time;

        this.save(recipe);
    }

    get cuisine(): Cuisine {
        return this.currentRecipe.cuisine
    }

    set cuisine(cusine: Cuisine){
        const recipe = this.currentRecipe;
        recipe.cuisine = cusine;

        this.save(recipe);
    }

    get dietStyle(): dietStyle {
        return this.currentRecipe.dietStyle;
    }

    set dietStyle(dietStyle: dietStyle){
        const recipe = this.currentRecipe;
        recipe.dietStyle = dietStyle;

        this.save(recipe);
    }

    get buttonDisabled() {
        return this.title === "" || this.timeToPrepare !== 0
    }

    get getButtonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    save(recipe: Recipe){
        this.$store.commit("updateRecipe", recipe);
    }
}
</script>

<style scoped>

</style>

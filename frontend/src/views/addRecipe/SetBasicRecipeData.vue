<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                v-model="title"
                type="text"
                label="Titel"
                class="input"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="dietStyle"
                :options="dietStyles"
                type="select"
                placeholder=""
                label="Ernährungsweise"
                class="input"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="cuisine"
                :options="cuisines"
                type="select"
                placeholder=""
                label="Küche"
                class="input"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="typeOfDish"
                :options="typesOfDish"
                type="select"
                placeholder=""
                label="Art der Speise"
                class="input"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="timeToCook"
                type="text"
                label="Arbeitszeit in Minuten"
                class="input"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="totalTime"
                type="text"
                label="Gesamteit in Minuten (inkl. Wartezeiten)"
                class="input"
            />
        </div>

        <div v-if="mode === 'add'" class="col-12">
            <div :disabled="buttonDisabled"
                 class="mt-3 btn btn-primary float-right"
                 :class="getButtonDisabledClass"
                 @click="nextStep"
            >
                Weiter
            </div>
        </div>
    </div>
</template>

<script lang="ts">


import Component from "vue-class-component";
import {Cuisine, dietStyle, Recipe, typeOfDish} from "@/types/recipe";
import Vue from "vue";
import {Prop} from "vue-property-decorator";

@Component
export default class SetBasicRecipeData extends Vue {

    @Prop({default: "add"}) mode = "add";

    cuisines = [
        {value: "DEUTSCH", label: "deutsch"},
        {value: "MEDITERAN", label: "mediteran"},
        {value: "ASIATISCH", label: "asiatisch"},
        {value: "AMERIKANISCH", label: "amerikanisch"},
        {value: "INDISCH", label: "indisch"},
    ];
    dietStyles = [
        {value: "ALLES", label: "alles"},
        {value: "VEGETARISCH", label: "vegetarisch"},
        {value: "VEGAN", label: "vegan"},
    ];
    typesOfDish = [
        {value: "VORSPEISE", label: "Vorspeise"},
        {value: "HAUPTSPEISE", label: "Hauptspeise"},
        {value: "NACHSPEISE", label: "Nachspeise"},
        {value: "SNACK", label: "Snack"},
    ]


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

    get timeToCook(): number {
        if(isNaN(this.currentRecipe.timeToCook)){
            return 0;
        }
        return this.currentRecipe.timeToCook;
    }

    set timeToCook(time: number) {
        const recipe = this.currentRecipe;
        //Is necessary, because the form returns a string for whatever reason
        recipe.timeToCook = Number.parseInt(time.toString());
        this.save(recipe);
    }

    get totalTime(): number{
        if (isNaN(this.currentRecipe.totalTime)){
            return 0;
        }
        return this.currentRecipe.totalTime;
    }

    set totalTime(time: number){
        const recipe = this.currentRecipe;
        //Is necessary, because the form returns a string for whatever reason
        recipe.totalTime = Number.parseInt(time.toString());
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

    get typeOfDish(): typeOfDish{
        return this.currentRecipe.typeOfDish;
    }

    set typeOfDish(typeOfDish: typeOfDish) {
        const recipe = this.currentRecipe;
        recipe.typeOfDish = typeOfDish;

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
        return this.title === "" || this.timeToCook === 0
    }

    get getButtonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    save(recipe: Recipe){
        this.$store.commit("updateRecipe", recipe);
    }

    nextStep(){
        this.$emit("goForward")
    }
}
</script>

<style scoped>

</style>

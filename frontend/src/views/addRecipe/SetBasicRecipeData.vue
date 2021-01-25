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
                 @click="emitData"
            >
                Weiter
            </div>
        </div>
    </div>
</template>

<script lang="ts">


import Component from "vue-class-component";
import {basicDataPayload, cuisine, dietStyle, recipe} from "@/types/recipe";
import Vue from "vue";

@Component
export default class SetBasicRecipeData extends Vue {

    title = "";
    declare dietStyle: dietStyle;
    declare cuisine: cuisine;
    timeToPrepare = 0;

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

    mounted(){
        if (!this.currentRecipe){
            return;
        }

        this.cuisine = this.currentRecipe.cuisine;
    }

    get currentRecipe(): recipe | undefined{
        return this.$store.getters.currentRecipe;
    }

    get buttonDisabled() {
        return this.title === "" || this.timeToPrepare !== 0
    }

    get getButtonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    emitData() {
        const payload: basicDataPayload = {
            title: this.title,
            dietStyle: this.dietStyle,
            cuisine: this.cuisine,
            timeToPrepare: this.timeToPrepare
        }
        this.$emit("dataSet", payload)
    }
}
</script>

<style scoped>

</style>

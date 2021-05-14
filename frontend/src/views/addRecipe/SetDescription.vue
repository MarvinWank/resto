<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                type="textarea"
                v-model="description"
                label="Beschreibung"
            />
        </div>

        <div class="col-12">
            <div class="mt-3 btn btn-primary float-left"
                 @click="goBack"
            >
                Zurück
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Recipe} from "@/types/value";

@Component
export default class SetDescription extends Vue {

    get currentRecipe(): Recipe{
        return this.$store.getters.currentRecipe;
    }

    get description(): string{
        return this.currentRecipe.description
    }

    //TODO: This is ludicrously bad perfomancewise
    set description(description: string){
        const recipe = this.currentRecipe;
        recipe.description = description;

        this.$store.commit("updateRecipe", recipe);
    }

    get buttonDisabled() {
        return this.description === "";
    }

    get buttonDisabledClass() {
        return {
            "disabled": this.buttonDisabled
        }
    }

    goBack() {
        this.$emit("goBack")
    }
    finish(){
        this.$emit("finish");
    }
}
</script>

<style scoped>

</style>

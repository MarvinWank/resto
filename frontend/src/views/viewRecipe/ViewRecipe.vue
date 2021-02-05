<template>

    <div>

    </div>

</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import {Recipe} from "@/types/recipe";
import api from "@/api/api";

@Component
export default class ViewRecipe extends Vue{

    declare private recipe: Recipe;

    async mounted(){
        this.recipe = await api.getRecipeById(Number(this.$route.params.id));
        console.log(this.recipe);
    }

}
</script>

<style scoped>

</style>

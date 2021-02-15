<template>

</template>

<script lang="ts">

import Vue from "vue"
import Component from "vue-class-component";
import {Recipe} from "@/types/recipe";
import api from "@/api/api";


@Component
export default class EditRecipe extends Vue{

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
        api.getRecipeById(Number(this.$route.params.id)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe() {
        return this.myRecipe;
    }
}

</script>

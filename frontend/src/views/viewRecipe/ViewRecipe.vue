<template>
    <div class="container-fluid">

        <YesNoModal
            :show-modal="showDeleteModal"
            :text="deleteModalText"
            @yes="deleteRecipe"
        />

        <div class="row mt-4">
            <div class="col-12">
                <div class="h3 my-auto">{{ recipe.title }}</div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-4 my-auto">
                <i class="las la-lg la-pencil-alt mr-2"
                   @click="editRecipe"
                >
                </i>
                <i class="las la-lg la-trash-alt"
                @click="showDeleteModal = true"
                ></i>
                <i class="las la-lg la-list"
                   @click="addIngredientsToShoppingList"
                >
                </i>
            </div>
        </div>


        <div class="row justify-content-between pt-2">
            <div class="col-12">
                <i class="las la-stopwatch"></i> {{ recipe.timeToCook }} min Kochzeit
            </div>
            <div class="col-12">
                <i class="las la-stopwatch"></i> {{ recipe.totalTime }} min Gesamtzeit
            </div>

            <!--                        <div class="col-12">-->
            <!--                            {{totalCalories(recipe)}} kcal-->
            <!--                        </div>-->
        </div>

        <div class="h5 mt-4">Zutaten</div>
        <div class="row">
            <div v-for="(ingredient, key) in recipe.ingredients" :key="key" class="col-12">
                - {{ ingredient.amount }}{{ ingredient.unit }} {{ ingredient.name }}
            </div>
        </div>

        <div class="h5 mt-4">Beschreibung</div>
        <p class="">
            {{ recipe.description }}
        </p>

    </div>

</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import {Recipe} from "@/types/recipe";
import api from "@/api/api";
import RestoHeader from "@/components/RestoHeader.vue";
import YesNoModal from "@/components/YesNoModal.vue";

@Component({
    components: {
        RestoHeader,
        YesNoModal
    }
})
export default class ViewRecipe extends Vue {

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
    showDeleteModal = false;

    created() {
        api.getRecipeById(Number(this.$route.params.id)).then(response => {
            this.myRecipe = response.recipe
        });
    }

    get recipe(): Recipe {
        return this.myRecipe;
    }

    editRecipe() {
        this.$router.push("/recipe/edit/" + this.recipe.id)
    }

    addIngredientsToShoppingList(){
        this.$router.push("/list/select/" + this.recipe?.id)
    }

    deleteRecipe() {
        this.showDeleteModal = false;
        api.deleteRecipe(this.recipe?.id);
    }

    get deleteModalText() {
        return "Wollen Sie das Rezept '" + this.recipe?.title + "' wirklich löschen?"
    }

}
</script>

<style scoped lang="scss">
i {
    color: $grey_darker;
}
</style>

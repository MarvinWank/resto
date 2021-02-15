<template>
    <div class="row recipe-card">
        <div class="col-12 inner">
            <div class="title" @click="showRecipe">{{ recipe.title }}</div>
            <div class="row justify-content-between pt-2 content">
                <div class="col-6" @click="showRecipe">
                    <i class="las la-stopwatch"></i> {{ recipe.totalTime }} min
                </div>

                <!--                        <div class="col-6">-->
                <!--                            {{totalCalories(recipe)}} kcal-->
                <!--                        </div>-->

                <div class="col-6 justify-content-end d-flex align-items-center">
                    <i class="las la-lg la-pencil-alt mr-2"
                       @click="editRecipe"
                    ></i>
                    <i class="las la-lg la-trash-alt"></i>
                </div>

            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Prop} from "vue-property-decorator";
import {Recipe} from "@/types/recipe";


@Component
export default class RecipeCard extends Vue {
    @Prop() private recipe: Recipe | undefined;

    showRecipe() {
        this.$router.push("/recipe/view/" + this.recipe?.id)
    }

    editRecipe(){
        this.$router.push("/recipe/edit/" + this.recipe?.id)
    }
}
</script>

<style scoped>

</style>

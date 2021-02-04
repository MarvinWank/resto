<template>
    <div class="row recipe-card" >
        <div class="col-12 inner">
            <div class="title">{{recipe.title}}</div>
            <div class="row justify-content-between pt-2 content">
                <div class="col-6">
                    <i class="las la-stopwatch"></i> {{recipe.totalTime}} min
                </div>

                <!--                        <div class="col-6">-->
                <!--                            {{totalCalories(recipe)}} kcal-->
                <!--                        </div>-->

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
}
</script>

<style scoped>

</style>

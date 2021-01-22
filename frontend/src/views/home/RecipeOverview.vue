<template>
    <div class="row">
        <!--        Liste von Rezepten-->

        <router-link class="col-12 add-recipe" to="recipe/add">
            <div class="mt-4">Rezept hinzufügen +</div>
        </router-link>

    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class RecipeOverview extends Vue{

}
</script>

<style scoped lang="scss">

.add-recipe {
    border: 2px dashed #cbcbcb;
    text-align: center;
    height: 5rem;
    color: $grey_lighter;

    cursor: pointer;
}

</style>

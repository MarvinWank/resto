<template>
    <div class="row recipe-card">
        <div class="col-12 inner">
            <div class="title cursor-pointer" @click="showRecipe">{{ recipe.title }}</div>

            <div class="row justify-content-between pt-2 content">
                <div class="col-6" @click="showRecipe">
                    <i class="las la-stopwatch"></i> {{ recipe.totalTime }} min
                </div>

                <!--                        <div class="col-6">-->
                <!--                            {{totalCalories(recipe)}} kcal-->
                <!--                        </div>-->

                <div class="col-auto justify-content-end d-flex align-items-center cursor-pointer">
                    <i class="las la-lg la-pencil-alt mr-2 "
                       @click="editRecipe"
                    ></i>
                    <i class="las la-lg la-trash-alt"
                        @click="showDeleteModal = true"
                    ></i>
                </div>
            </div>

        </div>

        <YesNoModal
            :show-modal="showDeleteModal"
            :text="deleteModalText"
            @yes="deleteRecipe"
        />
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Prop} from "vue-property-decorator";
import {Recipe} from "@/types/recipe";
import YesNoModal from "@/components/YesNoModal.vue";
import api from "@/api/api";
@Component({
    components: {YesNoModal}
})
export default class RecipeCard extends Vue {
    @Prop() private recipe: Recipe | undefined;

    showDeleteModal = false;

    get deleteModalText(){
        return "Wollen Sie das Rezept '" + this.recipe?.title + "' wirklich löschen?"
    }

    deleteRecipe(){
        this.showDeleteModal = false;
        if (this.recipe != undefined){
            api.deleteRecipe(this.recipe?.id);
        }
    }

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

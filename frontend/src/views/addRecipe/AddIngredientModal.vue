<template>
    <div class="modal-body" @keyup.enter="addIngredient">
        <h3 class="text-center">Neue Zutat hinzufügen</h3>

        <div class="row mt-5">
            <div class="col-12">
                <FormulateInput
                    v-model="name"
                    label="Name der Zutat"
                    type="text"
                />
            </div>

            <div class="col-9">
                <FormulateInput
                    v-model="amount"
                    label="Menge"
                    type="number"
                />
            </div>

            <div class="col-3">
                <FormulateInput
                    v-model="unit"
                    :options="units"
                    placeholder="g"
                    type="select"
                    label="einheit"
                />
            </div>
        </div>

        <button class="mt-3 btn btn-primary btn-block" @click="addIngredient">
            {{ name }} hinzufügen
        </button>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Ingredient, SI_UNIT} from "@/types/recipe";

@Component
export default class AddIngredientModal extends Vue implements Ingredient {

    units = ["g", "kg", "ml", "l", "Stk"];
    name =  ""
    amount = 0
    unit: SI_UNIT = "g";
    kcal = null;

    addIngredient(){
        const ingredient: Ingredient = {
            name: this.name,
            amount: this.amount,
            unit: this.unit,
            kcal: this.kcal
        }
        this.$emit("addIngredient", ingredient)
    }

}
</script>

<style scoped>

</style>

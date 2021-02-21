<template>
    <div class="modal-body" @keyup.enter="addIngredient">
        <h3 class="text-center">{{ name }} bearbeiten</h3>

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
            {{ name }} speichern
        </button>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Ingredient, SI_UNIT} from "@/types/recipe";
import {Prop} from "vue-property-decorator";

@Component
export default class AddIngredientModal extends Vue implements Ingredient {

    units = ["g", "kg", "ml", "l", "Stk"];
    @Prop() id: number;
    @Prop() name: string;
    @Prop() amount: number;
    @Prop() unit: SI_UNIT;
    @Prop() kcal = null;

    addIngredient() {
        const ingredient: Ingredient = {
            name: this.name,
            amount: this.amount,
            unit: this.unit,
            kcal: this.kcal
        }
        this.$emit("addIngredient", {ingredient: ingredient, id: this.id})
    }

}
</script>

<style scoped>

</style>

<template>
    <div class="row">
        <div class="col-12 mb-4">
            Zutaten
        </div>
        <div class="col-12 ">
            <div class="add-ingredient" @click="showModal">
                <div class="mt-3">Zutat hinzufügen +</div>
            </div>
        </div>

        <div v-for="(ingredient, key) in ingredients"  :key="key" class="col-12">
            <div class="ingredient-card">
                <div class="mt-3">
                    {{ingredient.amount}}{{ingredient.unit}} {{ingredient.name}}
                </div>
            </div>
        </div>

        <v-easy-dialog v-model="showDialog">
            <AddIngredientModal
                @addIngredient="addIngredient"
            />
        </v-easy-dialog>

        <div class="col-12">
            <div class="mt-3 btn btn-primary float-left"
                 @click="goBack"
            >
                Zurück
            </div>
            <div :disabled="buttonDisabled"
                 class="mt-3 btn btn-primary float-right"
                 :class="getButtonDisabledClass"
                 @click="emitData"
            >
                Weiter
            </div>
        </div>
    </div>
</template>

<script>

import VEasyDialog from 'v-easy-dialog'
import AddIngredientModal from "@/views/addRecipe/AddIngredientModal";


export default {
    name: "SetIngredients",

    components: {
        AddIngredientModal,
        VEasyDialog
    },

    data() {
        return {
            ingredients: {},
            showDialog: false

        }
    },

    computed: {
        buttonDisabled() {
            return Object.keys(this.ingredients).length === 0;
        },

        getButtonDisabledClass() {
            return {
                "disabled": this.buttonDisabled
            }
        }
    },

    methods: {
        showModal() {
            this.showDialog = true;
        },

        addIngredient(data) {
            this.ingredients[data.name] = {
                name: data.name,
                amount: data.amount,
                unit: data.unit
            };
            this.showDialog = false;
        },

        emitData(){
            this.$emit("ingredientsSet", this.ingredients)
        },
        goBack(){
            this.$emit("goBack", this.ingredients)
        }
    }
}
</script>

<style scoped lang="scss">

.add-ingredient {
    border: 2px dashed #cbcbcb;
    text-align: center;
    height: 4rem;
    color: $grey_lighter;

    cursor: pointer;
    margin-bottom: 1rem;
}

.ingredient-card {
    border: 2px solid #e3e3e3;
    height: 4rem;
    padding-left: 1rem;
    margin-bottom: .5rem;

    cursor: pointer;
}


</style>

<template>
    <div class="row">
        <div class="col-12 ">
            <div class="add-ingredient" @click="show_modal">
                <div class="mt-3">Zutat hinzufügen +</div>
            </div>
        </div>
        <v-easy-dialog v-model="showDialog">
            <AddIngredientModal

            />
        </v-easy-dialog>
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

    data(){
        return {
            ingredients: [],
            showDialog: false

        }
    },

    methods:{
        show_modal(){
            this.showDialog = true;
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
}

.example-modal-content {
    //  height: 100%;
    box-sizing: border-box;
    padding: 10px;
    font-size: 13px;
    line-height: 1.5;
    overflow: auto;
}

</style>

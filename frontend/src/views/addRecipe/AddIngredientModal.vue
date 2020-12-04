<template>
    <div class="modal-body">
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

        <button class="mt-3 btn btn-primary btn-block" @click="showDialog = false">
            Close
        </button>
    </div>
</template>

<script>
export default {
    name: "AddIngredientModal",

    data(){
        return {

            name: "",
            amount: "",
            unit: "",

            units: {
                gramm: "g", kilogramm: "kg", liter: "l",
            }
        }
    }
}
</script>

<style scoped>

</style>

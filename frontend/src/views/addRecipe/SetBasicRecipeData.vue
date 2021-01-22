<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                v-model="title"
                type="text"
                label="Titel"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="dietStyle"
                :options="dietStyles"
                type="select"
                placeholder=""
                label="Ernährungsweise"
            />
        </div>

        <div class="col-12">
            <FormulateInput
                v-model="cuisine"
                :options="cuisines"
                type="select"
                placeholder=""
                label="Küche"
            />
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="time_to_prepare">geschätzte Arbeitszeit (Minuten)</label>
                <input v-model="timeToPrepare" id="time_to_prepare" class="form-control">
            </div>
        </div>

        <div class="col-12">
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
export default {
    name: "SetBasicRecipeData",

    data() {
        return {
            "title": "",
            "dietStyle": null,
            "cuisine": null,
            "timeToPrepare": null,

            "dietStyles": [
                {label: "alles", value: "ALLES"},
                {label: "vegetarisch", value: "VEGETARISCH"},
                {label: "vegan", value: "VEGAN"},
            ],
            "cuisines": [
                {label: "deutsch", value: "DEUTSCH"},
                {label: "mediteran", value: "MEDITERAN"},
                {label: "asiatisch", value: "ASIATISCH"},
                {label: "amerikanisch", value: "AMERIKANISCH"},
                {label: "indisch", value: "INDISCH"},
            ]
        }
    },

    computed: {
        buttonDisabled() {
            return this.title === "" || this.dietStyle === null || this.cuisine === null || this.timeToPrepare === null
        },

        getButtonDisabledClass() {
            return {
                "disabled": this.buttonDisabled
            }
        }
    },

    methods: {
        emitData() {
            this.$emit("dataSet", {
                "title": this.title,
                "dietStyle": this.dietStyle,
                "cuisine": this.cuisine,
                "timeToPrepare": this.timeToPrepare
            })
        }
    }
}
</script>

<style scoped>

</style>

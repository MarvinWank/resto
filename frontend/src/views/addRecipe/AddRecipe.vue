<template>
    <div>
        <RestoHeader/>
        <h3 class=" mt-4">Neues Rezept anlegen</h3>
        <div class="row mt-5">

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
                    <label for="time_to_prepare">ungefähre Arbeitszeit (Minuten)</label>
                    <input v-model="timeToPrepare" id="time_to_prepare" class="form-control">
                </div>
            </div>
        </div>

        <div :disabled="buttonDisabled" class="mt-3 btn btn-primary btn-block" :class="getButtonDisabledClass">Rezept
            anlegen
        </div>
    </div>
</template>

<script>
import RestoHeader from "@/components/RestoHeader";

export default {
    name: "AddRecipe",
    components: {
        RestoHeader,
    },

    data() {
        return {
            "title": "",
            "dietStyle": null,
            "cuisine": null,
            "timeToPrepare": null,
            "ingredients": [],

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
            return this.title === "" || this.dietStyle === null || this.cuisine === null || this.timeToPrepare === null ||
                this.ingredients.length === 0
        },

        getButtonDisabledClass() {
            return {
                "disabled": this.buttonDisabled
            }
        }
    }

}
</script>

<style scoped>
.col-12 {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 0;
}
</style>

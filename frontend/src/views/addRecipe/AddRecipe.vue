<template>
    <div>
        <RestoHeader/>
        <h3 class=" mt-4">Neues Rezept anlegen</h3>
        <div class="row mt-5">

            <div class="col-12">
                <div class="form-group">
                    <label for="title">Titel</label>
                    <input v-model="title" id="title" class="form-control">
                </div>
            </div>

            <div class="col-12">
                <label for="title">Ernährungsweise</label>
                <v-select
                    label="title"
                    :options="dietStyles"
                    v-model="dietStyle"
                />
            </div>

            <div class="col-12">
                <label for="title">Küche</label>
                <v-select
                    label="title"
                    :options="cuisines"
                    v-model="cuisine"
                />
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="time_to_prepare">ungefähre Arbeitszeit (Minuten)</label>
                    <input v-model="timeToPrepare" id="time_to_prepare" class="form-control">
                </div>
            </div>
        </div>

        <div :disabled="buttonDisabled" class="mt-3 btn btn-primary btn-block" :class="getButtonDisabledClass">Rezept anlegen</div>
    </div>
</template>

<script>
import RestoHeader from "@/components/RestoHeader";
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select'

export default {
    name: "AddRecipe",
    components: {
        RestoHeader,
        vSelect
    },

    data() {
        return {
            "title": "",
            "dietStyle": null,
            "cuisine": null,
            "timeToPrepare": null,
            "ingredients": [],

            "dietStyles": [
                {title: "alles", value: "ALLES"},
                {title: "vegetarisch", value: "VEGETARISCH"},
                {title: "vegan", value: "VEGAN"},
            ],
            "cuisines": [
                {title: "deutsch", value: "DEUTSCH"},
                {title: "mediteran", value: "MEDITERAN"},
                {title: "asiatisch", value: "ASIATISCH"},
                {title: "amerikanisch", value: "AMERIKANISCH"},
                {title: "indisch", value: "INDISCH"},
            ]
        }
    },

    computed:{
        buttonDisabled(){
            return this.title === "" || this.dietStyle === null || this.cuisine === null || this.timeToPrepare === null ||
                this.ingredients.length === 0
        },

        getButtonDisabledClass(){
            return {
                "disabled": this.buttonDisabled
            }
        }
    }

}
</script>

<style scoped>
    .col-12{
        margin-bottom: 1.5rem;
    }

    .form-group{
        margin-bottom: 0;
    }
</style>

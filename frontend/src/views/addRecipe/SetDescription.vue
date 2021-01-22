<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                type="textarea"
                v-model="description"
                label="Bescr"
            />
        </div>

        <div class="col-12">
            <div class="mt-3 btn btn-primary float-left"
                 @click="goBack"
            >
                Zurück
            </div>
            <!--            <div :disabled="buttonDisabled"-->
            <!--                 class="mt-3 btn btn-primary float-right"-->
            <!--                 :class="getButtonDisabledClass"-->
            <!--                 @click="emitData"-->
            <!--            >-->
            <!--                Weiter-->
            <!--            </div>-->
        </div>
    </div>
</template>

<script>
export default {
    name: "SetDescription",

    data() {
        return {
            description: ""
        }
    },

    methods: {
        goBack(){
            this.$emit("goBack", this.ingredients)
        }
    }
}
</script>

<style scoped>

</style>

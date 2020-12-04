<template>
    <div class="row">
        <div class="col-12">
            <FormulateInput
                type="textarea"
                v-model="description"
                label="Bescr"
            />
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
    }
}
</script>

<style scoped>

</style>

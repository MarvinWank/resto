<template>
    <div class="row">
        <div class="col-12 ">
            <div class="add-ingredient">
                <div class="mt-3">Zutat hinzufügen +</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SetIngredients",

    data(){
        return {
            ingredients: []
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

</style>

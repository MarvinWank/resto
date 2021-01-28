<template>
    <div class="homescreen-header"
        @click="jumpToHome"
    >
        <p class="homescreen-headline">resto</p>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";

@Component
export default class RestoHeader extends Vue {

    jumpToHome(){
        this.$router.push("/");
    }
}
</script>

<style scoped lang="scss">

</style>

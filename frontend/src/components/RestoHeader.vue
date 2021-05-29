<template>
    <div id="resto-header"

    >
        <Menu
            v-if="isLoggedin"
        />
        <p class="homescreen-headline" @click="jumpToHome">resto</p>
    </div>
</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import router from "@/router/router";
import Menu from "@/components/Menu.vue";

@Component({
    components: {
        Menu,
    }
})
export default class RestoHeader extends Vue {

    get isLoggedin(): boolean{
        return this.$store.getters.isLoggedin;
    }

    jumpToHome() {
        this.$router.push("/");
    }

    showImprint() {
        router.push({name: "Imprint"});
    }
}
</script>

<style scoped lang="scss">

</style>

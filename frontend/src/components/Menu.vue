<template>
    <Slide>
        <div class="col-12 bm-link link-hover">
            <div @click="showHome()">Startseite</div>
        </div>
        <div class="mt-auto col-12 bm-link link-hover">
            <div @click="showImprint()">Impresseum</div>
        </div>

    </Slide>


</template>

<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import {Slide} from 'vue-burger-menu';
import router from "@/router/router";

@Component({
    components: {
        Slide,
    }
})
export default class Menu extends Vue {

    showHome() {
        router.push({name: "Home"});
    }

    showImprint() {
        router.push({name: "Imprint"});
    }

}
</script>

<style scoped>

</style>

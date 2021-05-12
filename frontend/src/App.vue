<template>
    <div>
        <div class="container-fluid container-lg container-xl" id="app">
            <router-view></router-view>
        </div>
        <div class="" id="imprint">
            <a class="link-secondary" href="#" @click="showImprint">Impresseum</a>
        </div>
    </div>
</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import Imprint from "@/views/footer/Imprint.vue";
import router from "@/router/router";

@Component({
    components: {Imprint}
})
export default class App extends Vue {

    showImprint(){
        router.push({name: "Imprint"})
    }

}

</script>

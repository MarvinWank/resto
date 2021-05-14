<template>
    <div>
        <RestoHeader />
        <div class="container-fluid container-lg container-xl" id="app">
            <router-view></router-view>
        </div>
        <div id="footer">
        </div>
    </div>
</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import Imprint from "@/views/footer/Imprint.vue";
import router from "@/router/router";
import RestoHeader from "@/components/RestoHeader.vue";

@Component({
    components: {RestoHeader, Imprint}
})
export default class App extends Vue {

    showImprint(){
        router.push({name: "Imprint"})
    }

}

</script>

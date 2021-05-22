<template>
    <div>
        <RestoHeader />
        <div class="container-fluid container-lg container-xl" id="app">
            <router-view></router-view>
            <MessageArea/>
        </div>
    </div>
</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";
import Imprint from "@/views/footer/Imprint.vue";
import router from "@/router/router";
import RestoHeader from "@/components/RestoHeader.vue";
import MessageArea from "@/views/footer/MessageArea.vue";

@Component({
    components: {MessageArea, RestoHeader, Imprint}
})
export default class App extends Vue {

    showImprint(){
        router.push({name: "Imprint"})
    }

}

</script>

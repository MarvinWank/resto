<template>
    <Slide>
        <div class="bm-user">
            {{this.user.name}}
        </div>
        <div class="col-12 bm-link link-hover">
            <div @click="showHome()">Startseite</div>
        </div>
        <div class="col-12 bm-link link-hover">
            <div @click="showProfile()">Profil</div>
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
import {User} from "@/types/user";

@Component({
    components: {
        Slide,
    }
})
export default class Menu extends Vue {

    get user(): User{
        return this.$store.getters.currentUser;
    }

    showHome() {
        router.push({name: "Home"});
    }

    showImprint() {
        router.push({name: "Imprint"});
    }

    showProfile() {
        router.push({name: "Profile"})
    }

}
</script>

<style scoped>

</style>

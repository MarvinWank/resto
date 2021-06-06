<template>
    <Slide
        :isOpen="isOpen"
        @openMenu="handleOpenMenu"
    >
        <div class="bm-user">
            {{this.user.name}}
        </div>
        <div class="col-12 bm-link link-hover">
            <div @click="showHome()">Startseite</div>
        </div>
        <div class="col-12 bm-link link-hover">
            <div @click="showShoppingList()">Einkaufsliste</div>
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
// No types available
/* eslint-disable */
// @ts-ignore
import {Slide} from 'vue-burger-menu';
import router from "@/router/router";
import {User} from "@/types/user";

@Component({
    components: {
        Slide,
    }
})
export default class Menu extends Vue {

    isOpen = false;

    get user(): User{
        if (this.$store.getters.currentUser !== undefined){
            return this.$store.getters.currentUser;
        }else {
            return {
                id: -1,
                name: '',
                email: ''
            }
        }
    }

    handleOpenMenu() {
        this.isOpen = true;
    }

    showHome() {
        this.isOpen = false;
        router.push({name: "Home"});
    }

    showShoppingList(){
        this.isOpen = false;
        router.push({name: "ViewShoppingList"});
    }

    showImprint() {
        this.isOpen = false;
        router.push({name: "Imprint"});
    }

    showProfile() {
        this.isOpen = false;
        router.push({name: "Profile"})
    }

}
</script>

<style scoped>

</style>

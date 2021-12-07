<template>
    <div class="col-12 mt-auto">

        <div style="width: 100%; text-align: center">
            <img class="img-fluid text-center" src="/img/icons/resto_logo.png">
        </div>

        <h2 class="mb-4 mt-3">
            Anmelden <span class="color-grey">oder</span> <a @click="register" href=""
                                                             class="link-primary">registrieren</a>
        </h2>

        <div class="form-group mt-4">
            <label for="email">E-Mail Adresse</label>
            <input v-model="email" type="email" class="form-control" id="email" placeholder="E-Mail Adresse">
        </div>
        <div class="form-group">
            <label for="passwort">Passwort</label>
            <input v-model="password" type="password" class="form-control" id="passwort" placeholder="Passwort">
        </div>
        <button type="submit" :class="getLoginButtonClasses" @click="attemptLogin">Anmelden</button>
    </div>
</template>

<script lang="ts">

import api from "../api/api";
import {Component, Vue} from 'vue-property-decorator'
import {setCookie} from "@/CookieHandler";
import router from "@/router/router";
import {currentMessage} from "@/types/app";

@Component
export default class Login extends Vue {
    email = '';
    password = '';

    get getLoginButtonClasses() {
        return {
            "mt-3": true,
            "btn": true,
            "btn-primary": true,
            "btn-block": true,
            "disabled": this.email === '' || this.password === ''
        }
    }

    register() {
        router.push({name: 'Register'});
    }


    async attemptLogin() {

        const apiResponse = await api.login(this.email, this.password);

        if (apiResponse.status !== "ok") {

            const message: currentMessage = {
                text: 'Login Fehlgeschlagen',
                type: 'error'
            }
            this.$store.commit("setCurrentMessage", message)
            return
        }

        this.$store.commit("resetCurrentMessage");
        setCookie(apiResponse.apiKey);

        await this.$store.dispatch('setInitialData', {
                "apiKey": apiResponse.apiKey,
                "user": apiResponse.user,
                "topRecipes": apiResponse.topRecipes,
                "shoppingList": apiResponse.shoppingList
            }
        )
    }
}
</script>

<style scoped>

</style>

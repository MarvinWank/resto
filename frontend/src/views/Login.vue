<template>
    <div class="col-12 mt-auto">

        <div style="width: 100%; text-align: center">
            <img class="img-fluid text-center" src="/img/icons/resto_logo.png">
        </div>

        <h2 class="mb-4 mt-3">Anmelden</h2>

        <div class="form-group mt-4">
            <label for="email">E-Mail Adresse</label>
            <input v-model="email" type="email" class="form-control" id="email" placeholder="E-Mail Adresse">
        </div>
        <div class="form-group">
            <label for="passwort">Passwort</label>
            <input v-model="password" type="password" class="form-control" id="passwort" placeholder="Passwort">
        </div>
        <div v-if="loginError" class="alert alert-danger">Login Fehlgeschlagen!</div>
        <button type="submit" :class="getLoginButtonClasses" @click="attemptLogin">Anmelden</button>
    </div>
</template>

<script lang="ts">

import api from "../api/api";
import {Component, Vue} from 'vue-property-decorator'

@Component
export default class Login extends Vue {
    email = '';
    password = '';
    loginError = false;

    get getLoginButtonClasses() {
        return {
            "btn": true,
            "btn-primary": true,
            "btn-block": true,
            "disabled": this.email === '' || this.password === ''
        }
    }


    async attemptLogin() {

        const apiResponse = await api.login(this.email, this.password);
        console.log(apiResponse);

        if (apiResponse.status !== "ok") {
            this.loginError = true;
            return
        }

        await this.$store.dispatch('authenticate', {
                "user": apiResponse.user,
                "topRecipes": apiResponse.topRecipes,
                "apiKey": apiResponse.apiKey
            }
        )
    }
}
</script>

<style scoped>

</style>

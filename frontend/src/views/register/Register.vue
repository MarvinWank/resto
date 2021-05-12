<template>
    <div class="col-12">

        <div style="width: 100%; text-align: center">
            <img class="img-fluid text-center" src="/img/icons/resto_logo.png">
        </div>

        <h2 class="mb-4 mt-3">
            Registrieren <span class="color-grey">oder</span> <a @click="login" href=""
                                                                 class="link-primary">anmeldem</a>
        </h2>

        <div class="form-group">
            <label for="username">Name</label>
            <input v-model="username" type="text" class="form-control" id="username"
                   placeholder="Name">
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="email_1">E-Mail Adresse</label>
                    <input v-model="email_1"
                           @blur="checkEmail"
                           type="email"
                           class="form-control"
                           id="email_1"
                           placeholder="E-Mail Adresse"
                    >
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="email_2">E-Mail Adresse wiederholen</label>
                    <input v-model="email_2"
                           @blur="checkEmail"
                           type="email"
                           class="form-control"
                           id="email_2"
                           placeholder="E-Mail Adresse wiederholen"
                    >
                </div>
            </div>

        </div>


        <div class="row mt-2">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="password_1">Passwort</label>
                    <input v-model="password_1" @blur="checkPassword" type="password" class="form-control" id="password_1"
                           placeholder="Passwort">
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="password_2">Passwort wiederholen</label>
                    <input v-model="password_2" @blur="checkPassword" type="password" class="form-control" id="password_2"
                           placeholder="Passwort wiederholen">
                </div>
            </div>
        </div>


        <div v-if="registerError" class="alert alert-danger">{{registerErrorMessage}}</div>
        <button type="submit" :class="getLoginButtonClasses" @click="attemptRegister">Registrieren</button>

    </div>
</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import router from "@/router/router";

@Component
export default class Register extends Vue {

    username = '';
    email_1 = '';
    email_2 = '';
    password_1 = '';
    password_2 = '';
    registerError = false;
    registerErrorMessage: '';


    login() {
        router.push({name: "Login"})
    }

    checkEmail(){
        if (this.email_1 === '' || this.email_2 === '' ){
            return;
        }

        if (this.email_1 === this.email_2){
            this.registerError = false;
            this.registerErrorMessage = '';
        }

        if (this.email_1 !== this.email_2){
            this.registerError = true;
            this.registerErrorMessage = "E-Mail Adressen stimmen nicht überein"
        }
    }

    checkPassword(){
        if (this.password_1 === '' || this.password_2 === '' ){
            return;
        }

        if (this.password_1 === this.password_2){
            this.registerError = false;
            this.registerErrorMessage = '';
        }

        if (this.password_1 !== this.password_2){
            this.registerError = true;
            this.registerErrorMessage = "Passwörter stimmen nicht überein"
        }
    }

    attemptRegister() {
        console.log("foo");
    }

    get getLoginButtonClasses() {
        return {
            "btn": true,
            "btn-primary": true,
            "btn-block": true,
            "disabled": this.username === '' || this.email_1 === '' || this.email_2 === '' || this.password_1 === '' || this.password_2 === ''
        }
    }

}

</script>

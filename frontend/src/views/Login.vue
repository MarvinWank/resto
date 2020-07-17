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
        <div v-if="login_fehler" class="alert alert-danger">Login Fehlgeschlagen!</div>
        <button type="submit" :class="get_login_button_classes" @click="attempt_login">Anmelden</button>
    </div>
</template>

<script>
    import axios from "axios";
    import api from "../api/api";

    export default {
        name: "Login",

        data() {
            return {
                'email': '',
                'password': '',
                'api_response': {},
                'login_fehler': false
            }
        },

        computed: {
            get_login_button_classes() {
                return {
                    "btn": true,
                    "btn-primary": true,
                    "btn-block": true,
                    "disabled": this.email === '' || this.password === ''
                }
            },
        },

        methods: {
            async attempt_login() {

                let api_response = await api.login(this.email, this.password);
                console.log(api_response);

                if(api_response.status === "fehler"){
                    this.login_fehler = true;
                    return
                }

               await this.$store.dispatch('authenticate', api_response.user)
            }
        }
    }
</script>

<style scoped>

</style>

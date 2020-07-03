<template>
    <div class="col-12 mt-auto" >

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
        <button type="submit" :class="get_button_classes" @click="attempt_login">Anmelden</button>
    </div>
</template>

<script>
    export default {
        name: "Login",

        data(){
            return{
                'email': '',
                'password': ''
            }
        },

        computed:{
            get_button_classes(){
                return {
                    "btn": true,
                    "btn-primary": true,
                    "btn-block": true,
                    "disabled": this.email === '' || this.password === ''
                }
            },
        },

        methods:{
            attempt_login(){
                this.$api.login(this.email, this.password);
            }
        }
    }
</script>

<style scoped>

</style>

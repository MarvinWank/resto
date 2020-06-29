<template>
    <div class="col-12">

        <div style="width: 100%; text-align: center">
            <img class="img-fluid text-center" src="/img/icons/resto_logo.png">
        </div>

        <h1 class="mb-4 text-center">Anmelden</h1>

        <div class="form-group mt-3">
            <label for="email">E-Mail Adresse</label>
            <input type="email" class="form-control" id="email" placeholder="E-Mail Adresse">
        </div>
        <div class="form-group">
            <label for="passwort">Passwort</label>
            <input type="password" class="form-control" id="passwort" placeholder="Passwort">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
    </div>
</template>

<script>
    export default {
        name: "Login"
    }
</script>

<style scoped>

</style>

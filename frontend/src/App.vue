<template>
    <div class="container-fluid container-lg container-xl" id="app">
        <router-view></router-view>
    </div>
</template>

<script lang="ts">

import Component from "vue-class-component";
import Vue from "vue";

@Component
export default class App extends Vue{
}

</script>

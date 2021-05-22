<template>
    <div class="container-fluid container-lg container-xl" id="message-area">

        <div v-if="message.text !== ''" :class="classNames">
            {{ message.text }}
        </div>

    </div>

</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import {currentMessage} from "@/types/app";

@Component
export default class MessageArea extends Vue {


    get message(): currentMessage {
        return this.$store.getters.currentMessage;
    }

    get classNames() {
        return {
            'alert': true,
            'alert-success': this.message.type === 'success',
            'alert-danger': this.message.type === 'error'
        }
    }

}

</script>

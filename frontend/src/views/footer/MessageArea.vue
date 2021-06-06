<template>
    <div class="" id="message-area">

        <div v-if="message.text !== ''" :class="classNames">
            {{ message.text }}
            <i class="las la-times" id="message-close-icon"
               @click="resetMessage"
            ></i>
        </div>

    </div>

</template>

<script lang="ts">

import Vue from "vue";
import Component from "vue-class-component";
import {currentMessage} from "@/types/app";
import SelectIngredientsToAdd from "@/views/shoppingList/SelectIngredientsToAdd.vue";
@Component({
    components: {SelectIngredientsToAdd}
})
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

    resetMessage(){
        this.$store.commit("resetCurrentMessage")
    }

}

</script>

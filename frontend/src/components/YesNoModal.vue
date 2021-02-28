<template>
    <v-easy-dialog v-model="showModal">
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    {{ text }}
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <button class="btn btn-block btn-secondary" @click="emitNo">
                        Nein
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-block btn-primary" @click="emitYes">
                        Ja
                    </button>
                </div>
            </div>

        </div>
    </v-easy-dialog>
</template>

<script lang="ts">

/* @ts-ignore */
import VEasyDialog from 'v-easy-dialog'

import Vue from "vue";
import Component from "vue-class-component";
import {Prop} from "vue-property-decorator";

@Component({
    components: {
        VEasyDialog
    }
})
export default class YesNoModal extends Vue {

    @Prop({default: false}) showModal: boolean;
    @Prop() text: string;

    emitYes(){
        this.$emit("yes")
    }

    emitNo(){
        this.$emit("no")
    }
}
</script>

<style scoped>

</style>

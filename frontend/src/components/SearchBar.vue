<template>
    <div class="row">
        <div class="col-12">
            <autocomplete :search="search">

            </autocomplete>
        </div>
    </div>

</template>

<script lang="ts">

import Vue from "vue"
import Component from "vue-class-component";
// No types available
// @ts-ignore
import Autocomplete from '@trevoreyre/autocomplete-vue';

@Component({
    components: {
        Autocomplete
    }
})
export default class SearchBar extends Vue {

    search() {

    }

}
</script>

<style scoped>

</style>

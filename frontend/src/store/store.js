import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({

    state: {
        isLoggedin: false,
        user: {}
    },

    getters:{
        isLoggedin : state => state.isLoggedin
    }

});

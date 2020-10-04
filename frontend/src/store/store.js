import Vue from 'vue'
import Vuex from 'vuex'
import router from "../router/router";

Vue.use(Vuex)

export default new Vuex.Store({

    state: {
        isLoggedin: false,
        user: {},
        apiKey: ""
    },

    mutations: {
        setzeDatenInitial(state, daten){
            state.apiKey = daten.apiKey;
            state.user = daten.user;
            state.isLoggedin = true;
        }
    },

    actions:{
        authenticate(context, {user, apiKey}){
            console.log(apiKey)

            context.commit("setzeDatenInitial", {apiKey: apiKey, user: user})

            router.push("/home")
        }
    },



    getters:{
        isLoggedin : state => state.isLoggedin,
        currentUser: state => state.user,
        apiKey: state => state.apiKey
    }

});

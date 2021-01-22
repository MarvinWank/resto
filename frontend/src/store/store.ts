import Vue from 'vue'
import Vuex from 'vuex'
import router from "../router/router";
import api from "../api/api";

Vue.use(Vuex)

export default new Vuex.Store({

    state: {
        isLoggedin: false,
        user: {},
        apiKey: "",
        recipeCurentlyAdded: {}
    },

    mutations: {
        setzeDatenInitial(state, daten){
            state.apiKey = daten.apiKey;
            state.user = daten.user;
            state.isLoggedin = true;
        },
        addRecipe(state, recipe){

        },
        updateRecipe(state, {recipeId, recipe}){

        }
    },

    actions:{
        authenticate(context, {user, apiKey}){
            context.commit("setzeDatenInitial", {apiKey: apiKey, user: user})
            router.push("/")
        }
    },



    getters:{
        isLoggedin : state => state.isLoggedin,
        currentUser: state => state.user,
        apiKey: state => state.apiKey
    }

});

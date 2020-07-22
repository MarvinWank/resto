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

    },

    actions:{
        authenticate(context, {user, apiKey}){
            console.log(user)

            context.state.user = user;
            context.state.isLoggedin = true;
            context.state.apiKey = apiKey;

            router.push("/home")
        }
    },



    getters:{
        isLoggedin : state => state.isLoggedin,
        currentUser: state => state.user,
        apiKey: state => state.apiKey
    }

});

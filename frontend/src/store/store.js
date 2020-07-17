import Vue from 'vue'
import Vuex from 'vuex'
import router from "../router/router";

Vue.use(Vuex)

export default new Vuex.Store({

    state: {
        isLoggedin: false,
        user: {}
    },

    mutations: {

    },

    actions:{
        authenticate(context, user){
            console.log(user)

            context.state.user = user;
            context.state.isLoggedin = true;

            router.push("/home")
        }
    },



    getters:{
        isLoggedin : state => state.isLoggedin
    }

});

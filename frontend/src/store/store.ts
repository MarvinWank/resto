import Vue from 'vue'
import Vuex, {ActionTree, GetterTree, MutationTree} from 'vuex'
import router from "../router/router";
import {restoState} from "@/types/store";
import {setInitialDataPayload} from "@/types/api";
import {User} from "@/types/user";
import {recipe} from "@/types/recipe";
import api from "@/api/api";

Vue.use(Vuex)

const state: restoState = {
    apiKey: "",
    isLoggedin: false,
    user: undefined,

    recipeCurentlyBeingAdded: undefined
}

const mutations: MutationTree<restoState> = {
    setDataInitial(state: restoState, daten: setInitialDataPayload) {
        state.apiKey = daten.apiKey;
        state.user = daten.user;
        state.isLoggedin = true;
    },
    updateRecipe(state: restoState, recipe: recipe){
        state.recipeCurentlyBeingAdded = recipe;
    },
    saveRecipe(state: restoState){
        if (state.recipeCurentlyBeingAdded !== undefined){
            api.addRecipe(state.recipeCurentlyBeingAdded);
        }
    }
}

const actions: ActionTree<restoState, any> = {
    authenticate(context, payload: setInitialDataPayload) {
        context.commit("setDataInitial", payload)
        router.push("/")
    }
}

const getters: GetterTree<restoState, any> = {
    isLoggedin(state: restoState): boolean {
        return state.isLoggedin
    },
    currentUser(state: restoState): User | undefined{
        return state.user;
    },
    apiKey(state: restoState): string{
        return state.apiKey
    },

    currentRecipe(state: restoState): recipe | undefined{
        return state.recipeCurentlyBeingAdded;
    }
}

export default new Vuex.Store({

    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
});

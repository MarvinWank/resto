import Vue from 'vue'
import Vuex, {ActionTree, GetterTree, MutationTree} from 'vuex'
import router from "../router/router";
import {restoState} from "@/types/store";
import {setzeDatenInitialPayload} from "@/types/api";
import {User} from "@/types/user";

Vue.use(Vuex)

const state: restoState = {
    apiKey: "",
    isLoggedin: false,
    user: undefined,

    recipeCurentlyBeingAdded: undefined
}

const mutations: MutationTree<restoState> = {
    setzeDatenInitial(state: restoState, daten: setzeDatenInitialPayload) {
        state.apiKey = daten.apiKey;
        state.user = daten.user;
        state.isLoggedin = true;
    },
}

const actions: ActionTree<restoState, any> = {
    authenticate(context, payload: setzeDatenInitialPayload) {
        context.commit("setzeDatenInitial", payload)
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
    }
}

export default new Vuex.Store({

    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
});

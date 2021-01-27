import Vue from 'vue'
import Vuex, {ActionTree, GetterTree, MutationTree} from 'vuex'
import router from "../router/router";
import {restoState} from "@/types/store";
import {setInitialDataPayload} from "@/types/api";
import {User} from "@/types/user";
import {Recipe} from "@/types/recipe";
import api from "@/api/api";

Vue.use(Vuex)

const state: restoState = {
    apiKey: "",
    isLoggedin: false,
    user: undefined,

    recipeCurentlyBeingAdded: {
        cuisine: "deutsch",
        dietStyle: "alles",
        ingredients: [],
        timeToPrepare: 0,
        title: "",
        description: ""
    }
}

const mutations: MutationTree<restoState> = {
    setDataInitial(state: restoState, daten: setInitialDataPayload) {
        state.apiKey = daten.apiKey;
        state.user = daten.user;
        state.isLoggedin = true;
    },
    updateRecipe(state: restoState, recipe: Recipe) {
        state.recipeCurentlyBeingAdded = recipe;
    },
    async saveRecipe(state: restoState) {
        if (state.recipeCurentlyBeingAdded !== undefined) {
            const result = await api.addRecipe(state.recipeCurentlyBeingAdded);
            console.log(result);
        }
    },
    resetCurrentRecipe(state: restoState){
        state.recipeCurentlyBeingAdded = {
            cuisine: "deutsch",
            dietStyle: "alles",
            ingredients: [],
            timeToPrepare: 0,
            title: "",
            description: ""
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
    currentUser(state: restoState): User | undefined {
        return state.user;
    },
    apiKey(state: restoState): string {
        return state.apiKey
    },

    currentRecipe(state: restoState): Recipe {
        return state.recipeCurentlyBeingAdded;
    }
}

export default new Vuex.Store({

    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
});

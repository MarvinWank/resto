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
    topRecipes: [],

    recipeCurentlyBeingAdded: {
        id: -1,
        cuisine: "deutsch",
        dietStyle: "alles",
        ingredients: [],
        timeToCook: 0,
        totalTime: 0,
        title: "",
        description: ""
    }
}

const mutations: MutationTree<restoState> = {
        setDataInitial(state: restoState, daten: setInitialDataPayload) {
        state.apiKey = daten.apiKey;
        state.user = daten.user;
        state.topRecipes = daten.topRecipes;
        state.isLoggedin = true;
    },
    updateRecipe(state: restoState, recipe: Recipe) {
        state.recipeCurentlyBeingAdded = recipe;
    },
    async addRecipe(state: restoState) {
        if (state.recipeCurentlyBeingAdded !== undefined) {
            return await api.addRecipe(state.recipeCurentlyBeingAdded);
        }
    },
    async saveRecipe(state: restoState){
        if (state.recipeCurentlyBeingAdded !== undefined) {
            return await api.saveRecipe(state.recipeCurentlyBeingAdded);
        }
    },
    resetCurrentRecipe(state: restoState){
        state.recipeCurentlyBeingAdded = {
            id: -1,
            cuisine: "deutsch",
            dietStyle: "alles",
            ingredients: [],
            timeToCook: 0,
            totalTime: 0,
            title: "",
            description: ""
        }
    }
}

const actions: ActionTree<restoState, any> = {
    setInitialData(context, payload: setInitialDataPayload) {
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
    },
    topRecipes(state: restoState): Array<Recipe>{
        return state.topRecipes;
    }
}

export default new Vuex.Store({

    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
});

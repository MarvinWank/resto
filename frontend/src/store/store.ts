import Vue from 'vue'
import Vuex, {ActionTree, GetterTree, MutationTree} from 'vuex'
import router from "../router/router";
import {restoState} from "@/types/store";
import {setInitialDataPayload} from "@/types/api";
import {User} from "@/types/user";
import {Ingredient, Recipe} from "@/types/recipe";
import api from "@/api/api";
import {currentMessage} from "@/types/app";
import {IngredientsSet, ShoppingList} from "@/types/value";

Vue.use(Vuex)

const state: restoState = {
    apiKey: "",
    isLoggedin: false,
    user: undefined,
    topRecipes: [],
    currentMessage: {
        type: "success",
        text: '',
    },

    recipeCurentlyBeingAdded: {
        id: -1,
        cuisine: "deutsch",
        dietStyle: "alles",
        ingredients: [],
        timeToCook: 0,
        totalTime: 0,
        title: "",
        description: ""
    },
    shoppingList: {
        id: 0,
        ingredients: [],
        userId: 0
    }
}

const mutations: MutationTree<restoState> = {
    setDataInitial(state: restoState, daten: setInitialDataPayload) {
        state.apiKey = daten.apiKey;
        state.user = daten.user;
        state.topRecipes = daten.topRecipes;
        state.shoppingList = daten.shoppingList;
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
    async saveRecipe(state: restoState) {
        if (state.recipeCurentlyBeingAdded !== undefined) {
            return await api.saveRecipe(state.recipeCurentlyBeingAdded);
        }
    },
    resetCurrentRecipe(state: restoState) {
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
    },
    setCurrentMessage(state: restoState, currentMessage: currentMessage) {
        state.currentMessage = currentMessage;
    },
    resetCurrentMessage(state: restoState){
        state.currentMessage.text = '';
    },
    addIngredientToShoppingList(state: restoState, ingredientsSet: IngredientsSet) {
        api.addItemsToShoppingList(ingredientsSet).then( response => {

            if (response.status === "error"){
                state.currentMessage.type = "error";
                state.currentMessage.text = "Fehler beim Hnzufügen zur Einkaufsliste"
            }

            state.currentMessage.type = "success";
            state.currentMessage.text = "Zutaten erfolgreich zur Einkaufsliste hinzugefügt"
            state.shoppingList = response.shoppingList;
        });
    },
    deleteIngredientsFromShoppingList(state: restoState, IngrediensSet: IngredientsSet){
        api.removeItemsFromShoppingList(IngrediensSet).then( response => {

            if (response.status === "error"){
                state.currentMessage.type = "error";
                state.currentMessage.text = "Fehler beim Entfernen von der Einkaufsliste"
            }

            state.currentMessage.type = "success";
            state.currentMessage.text = "Zutaten erfolgreich von der Einkaufslist entfernt"
            state.shoppingList = response.shoppingList;
        });
    }
}

const actions: ActionTree<restoState, any> = {
    setInitialData(context, payload: setInitialDataPayload) {
        context.commit("setDataInitial", payload)
        const targetUrl = payload.targetUrl !== undefined ? payload.targetUrl : "/";
        router.push(targetUrl)
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
    currentMessage(state: restoState): currentMessage {
        return state.currentMessage;
    },

    currentRecipe(state: restoState): Recipe {
        return state.recipeCurentlyBeingAdded;
    },
    topRecipes(state: restoState): Array<Recipe> {
        return state.topRecipes;
    },
    shoppingList(state: restoState): ShoppingList {
        return state.shoppingList
    }
}

export default new Vuex.Store({
    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
});

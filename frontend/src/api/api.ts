import store from "../store/store";
import axios from "axios"
import router from "@/router/router";
import {Recipe} from "@/types/recipe";
import {IngredientsSet, ShoppingList} from "@/types/value";

class Api {
    host = '';

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "http://resto.local/api";
        }
        if (process.env.NODE_ENV === "production") {
            this.host = "https://resto.marvin-wank.de/api";
        }
    }

    getHost() {
        return this.host;
    }

    async post(route: string, data: any) {
        const result = await axios.post(this.host + route, {
            ...data,
            "apiKey": store.getters.apiKey
        }).then(res => res.data)

        if (result.message === "apiKey ungueltig") {
            router.push('/login');
            return {};
        }
        return result;
    }

    //Actions
    async login(email: string, password: string) {
        const data = await this.post('/login', {email: email, password: password})
        return data;
    }

    register(username: string, email: string, password: string) {
        return this.post('/register', {name: username, email: email, password: password})
    }

    async loginWithApiKey(apiKey: string) {
        const result = await axios.post(this.host + "/login_with_api_key", {
            "apiKey": apiKey
        }).then(res => res.data)

        if (result.message === "apiKey ungueltig") {
            router.push('/login');
            return {};
        }
        return result;
    }

    async addRecipe(recipe: Recipe) {
        const data = await this.post('/recipes/add', {recipe: recipe})
        return data;
    }

    async saveRecipe(recipe: Recipe) {
        return await this.post("/recipes/update", {recipe: recipe});
    }

    async getRecipeById(id: number) {
        const data = await this.post('/recipes/get_by_id', {id: id})
        return data;
    }

    async deleteRecipe(recipeId: number) {
        return await this.post("/recipes/delete", {id: recipeId});
    }

    saytSearch(search: string) {
        return this.post("/recipes/search/sayt", {search: search})
    }

    addItemsToShoppingList(ingredients: IngredientsSet){
        return this.post("/list/add_items", {ingredients: ingredients})
    }
}

export default new Api();

import store from "../store/store";
import axios from "axios"
import router from "@/router/router";
import {Recipe} from "@/types/recipe";

class Api {
    host = '';

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "http://resto.local/api";
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

    async addRecipe(recipe: Recipe) {
        const data = await this.post('/recipes/add', {recipe: recipe})
        return data;
    }

    async saveRecipe(recipe: Recipe){
        return await this.post("/recipes/updateRecuoe", {recipe: recipe});
    }

    async getRecipeById(id: number) {
        const data = await this.post('/recipes/get_by_id', {id: id})
        return data;
    }
}

export default new Api();

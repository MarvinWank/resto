import store from "../store/store";
import axios from "axios"
import router from "@/router/router";

class Api {
    host = '';

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "http://resto.local";
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

    async addRecipe(recipe: any) {
        const data = await this.post('/recipes/add', {recipe: recipe})
        return data;
    }
}

export default new Api();

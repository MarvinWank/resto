import store from "../store/store";
import axios from "axios"
import router from "@/router/router";

class api {
    host

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "http://resto.local";
        }

    }

    get_host() {
        return this.host;
    }

    async login(email, password) {
        const data = await this.post('/login', {email: email, password: password})
        return data;
    }

    async post(route, data) {
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
}

export default new api();

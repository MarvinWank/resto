import store from "../store/store";
import axios from "axios"

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

    async post(route, data){
        return await axios.post(this.host + route, {...data, "apiKey": store.getters.apiKey}).then(res => res.data)
    }
}

export default new api();

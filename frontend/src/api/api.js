const superagent = require('superagent');
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
        let user = await axios.post('http://resto.local/login', {
            "email": email,
            "password": password
        }).then(res => res.data)

        return user;

    }
}

export default new api();

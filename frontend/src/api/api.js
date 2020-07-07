import axios from "axios"
import store from "../store/store";

class api {
    host

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "localhost:8000";
        }

    }

    get_host() {
        return this.host;
    }

    login(email, passwort) {

        let result = alios.post(this.host + '/login', {
            email: email,
            passwort: passwort
        })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
}

export default new api();

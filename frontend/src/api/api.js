const superagent = require('superagent');
import store from "../store/store";

class api {
    host

    constructor() {
        if (process.env.NODE_ENV === "development") {
            this.host = "localhost:8000/index.php";
        }

    }

    get_host() {
        return this.host;
    }

    login(email, passwort) {
        superagent.post('http://resto.local/login')
            .send({"email": email})
            .then(res => {
                console.log(res);
            })
            .catch(console.error);
    }
}

export default new api();

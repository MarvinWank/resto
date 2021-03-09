import Vue from "vue";
import api from "@/api/api";
import store from "@/store/store";

export function getApiKeyFromCookie(): false | string {
    if (!Vue.$cookies.isKey("apiKey")){
        return false;
    }

    return Vue.$cookies.get("apiKey");
}

export function loginWithCookie(): false | void{
    if (!getApiKeyFromCookie()){
        return false;
    }

    const apiKey = getApiKeyFromCookie().toString();
    console.log(apiKey);
    api.loginWithApiKey(apiKey).then(res => {
        console.log(res);

        if (res.status !== "ok"){
            return;
        }
        store.dispatch("setInitialData", res)
    }).catch(res => {
        console.error(res)
    });
}

export function setCookie(apiKey: string){
    Vue.$cookies.set("apiKey", apiKey);
}

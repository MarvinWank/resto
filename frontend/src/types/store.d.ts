import {User} from "./user"
import {recipe} from "@/types/recipe";

export interface restoState {
    apiKey: string,
    isLoggedin: boolean,
    user?: User,

    recipeCurentlyBeingAdded?: recipe
}

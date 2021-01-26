import {User} from "./user"
import {Recipe} from "@/types/recipe";

export interface restoState {
    apiKey: string,
    isLoggedin: boolean,
    user?: User,

    recipeCurentlyBeingAdded: Recipe
}

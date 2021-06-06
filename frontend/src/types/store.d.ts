import {User} from "./user"
import {Recipe} from "@/types/recipe";
import {ShoppingList} from "@/types/value";
import {currentMessage} from "@/types/app";

export interface restoState {
    apiKey: string,
    isLoggedin: boolean,
    user?: User,
    topRecipes: Array<Recipe>,
    shoppingList: ShoppingList
    currentMessage: currentMessage,

    recipeCurentlyBeingAdded: Recipe
}

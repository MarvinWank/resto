import {User} from "./user"
import {Recipe} from "@/types/recipe";
import {ShoppingList} from "@/types/value";

export interface restoState {
    apiKey: string,
    isLoggedin: boolean,
    user?: User,
    topRecipes: Array<Recipe>,
    shoppingList?: ShoppingList

    recipeCurentlyBeingAdded: Recipe
}

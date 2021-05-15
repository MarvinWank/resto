import {User} from "@/types/user";
import {Recipe} from "@/types/recipe";
import {ShoppingList} from "@/types/value";

export interface setInitialDataPayload {
    apiKey: string,
    user: User,
    topRecipes: Array<Recipe>,
    shoppingList?: ShoppingList,
    targetUrl?: string
}

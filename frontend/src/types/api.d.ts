import {User} from "@/types/user";
import {Recipe} from "@/types/recipe";

export interface setInitialDataPayload {
    apiKey: string,
    user: User,
    topRecipes: Array<Recipe>,
    targetUrl?: string
}

export interface Recipe {
    title: string,
    dietStyle: dietStyle,
    cuisine: Cuisine,
    timeToPrepare: int,
    ingredients: Array<Ingredient>
}

export type dietStyle = "alles" | "vegetarisch" | "vegan"

export type Cuisine = "deutsch" | "mediteran" | "asiatisch" | "amerikanisch" | "indisch";

export interface Ingredient {
    name: string,
    gramm: int,
}

export interface basicDataPayload {
    title: string,
    dietStyle: dietStyle,
    cuisine: Cuisine,
    timeToPrepare: number
}

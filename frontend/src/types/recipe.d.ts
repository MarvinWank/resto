export interface Recipe {
    title: string,
    dietStyle: dietStyle,
    cuisine: Cuisine,
    timeToPrepare: int,
    ingredients: Array<Ingredient>,
    description: string,
}

export type dietStyle = "alles" | "vegetarisch" | "vegan"

export type Cuisine = "deutsch" | "mediteran" | "asiatisch" | "amerikanisch" | "indisch";

export interface Ingredient {
    name: string,
    amount: number,
    unit: SI_UNIT,
}

export interface basicDataPayload {
    title: string,
    dietStyle: dietStyle,
    cuisine: Cuisine,
    timeToPrepare: number
}

type SI_UNIT = "g" | "kg" | "ml" | "l";

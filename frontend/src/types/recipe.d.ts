export interface recipe {
    title: string,
    dietStye: dietStyle,
    timeToPrepare: int,
    ingredients: Array<Ingredient>
}

export type dietStyle = "alles" | "vegetarisch" | "vegan"

export type cuisine = "deutsch" | "mediteran" | "asiatisch" | "amerikanisch" | "indisch";

export interface Ingredient {
    name: string,
    gramm: int,
}

export interface basicDataPayload {
    title: string,
    dietStyle: dietStyle,
    cuisine: cuisine,
    timeToPrepare: number
}

export interface recipe {
    title: string,
    dietStye: dietStyle,
    timeToPrepare: int,
    ingredients: Array<Ingredient>
}

export enum dietStyle {
    ALLES = "alles",
    VEGETARISCH = "vegetarisch",
    VEGAN = "vegan"
}

export enum cuisine {
    DEUTSCH = 'deutsch',
    MEDITERAN = 'mediteran',
    ASIATISCH = 'asiatisch',
    AMERIKANISCH = 'amerikanisch',
    INDISCH = 'indisch',
}

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

export interface recipe {
    title: string,
    dietStye: dietStyle,
    timeToPrepare: int,
    ingredients: Array<Ingredient>
}

enum dietStyle {
    ALLES = "alles",
    VEGETARISCH = "vegetarisch",
    VEGAN = "vegan"
}

enum cuisine {
    DEUTSCH = 'deutsch',
    MEDITERAN = 'mediteran',
    ASIATISCH = 'asiatisch',
    AMERIKANISCH = 'amerikanisch',
    INDISCH = 'indisch',
}

interface Ingredient {
    name: string,
    gramm: int,
}

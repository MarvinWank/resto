export interface Recipe {
    id: number;
    title: string;
    dietStyle: dietStyle;
    typeOfDish: typeOfDish,
    cuisine: Cuisine;
    timeToCook: number;
    totalTime: number;
    ingredients: Array<Ingredient>;
    description: string;
}

export type dietStyle = "alles" | "vegetarisch" | "vegan"

export type typeOfDish = "Vorspeise" | "Hauptspeise" | "Nachspeise" | "Snack"

export type Cuisine = "deutsch" | "mediteran" | "asiatisch" | "amerikanisch" | "indisch";

export interface Ingredient {
    name: string;
    amount: number;
    unit: SI_UNIT;
    kcal: number | null;
}

type SI_UNIT = "g" | "kg" | "ml" | "l"| "Stk"| "EL"| "TL";

export enum DietStyle {
	ALLES = 'alles',
	VEGETARISCH = 'vegetarisch',
	VEGAN = 'vegan',
}

export enum Cuisine {
	DEUTSCH = 'deutsch',
	MEDITERAN = 'mediteran',
	ASIATISCH = 'asiatisch',
	AMERIKANISCH = 'amerikanisch',
	INDISCH = 'indisch',
}

export interface AddRecipeRequestDto {
	title: string
	dietStyle: string
	cuisine: string
	timeToCook: number
	totalTime: number
	ingredients: IngredientsSet
	description: string
}

export interface Recipe {
	id: number
	title: string
	author: User
	dietStyle: DietStyle
	cuisine: Cuisine
	timeToCook: number
	totalTime: number
	ingredients: IngredientsSet
	description: string
}

export interface User {
	id: number
	name: string
	email: string
}

export interface Ingredient {
	name: string
	amount: number
	unit: SIUnit
	kcal?: number
}

export type IngredientsSet = Array<Ingredient>

export enum SIUnit {
	g = 'gramm',
	kg = 'kilogramm',
	ml = 'millilitre',
	l = 'litre',
	Stk = 'pieces',
	TL = 'teaspoons',
	EL = 'tablespoons',
}

export type RecipeSet = Array<Recipe>

export interface ShoppingList {
	id?: number
	userId: number
	ingredients: IngredientsSet
}


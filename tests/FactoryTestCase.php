<?php


use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\SIUnit;
use App\Value\TypeOfDish;

class FactoryTestCase extends TestCase
{
    protected RecipeFactory $recipeFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipeFactory = app(RecipeFactory::class);
    }

    protected function generateRecipes(\App\Value\User  $user): array
    {
        $recipes = [];
        $ingredients = $this->generateIngredients();

        $recipes[] = $this->recipeFactory->addRecipe(
            $user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            TypeOfDish::HAUPTSPEISE(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $user,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            TypeOfDish::VORSPEISE(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $user,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            TypeOfDish::NACHSPEISE(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $user,
            "Sayt Test Recipe",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            TypeOfDish::NACHSPEISE(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        return $recipes;
    }

    protected function generateIngredients(): IngredientsSet
    {
        return IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
    }
}

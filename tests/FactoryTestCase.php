<?php


use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\SIUnit;

class FactoryTestCase extends TestCase
{
    protected RecipeFactory $recipeFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipeFactory = app(RecipeFactory::class);
    }

    protected function generateRecipes(): array
    {
        $recipes = [];

        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        $recipes[] = $this->recipeFactory->addRecipe(
            $this->testUser,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $this->testUser,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $this->testUser,
            "Test Rezept 2",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
        $recipes[] = $this->recipeFactory->addRecipe(
            $this->testUser,
            "Sayt Test Recipe",
            DietStyle::VEGAN(),
            Cuisine::ASIATISCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );

        return $recipes;
    }
}

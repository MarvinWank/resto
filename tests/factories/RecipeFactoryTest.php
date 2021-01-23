<?php


namespace factories;


use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;

class RecipeFactoryTest extends \FactoryTestCase
{
    private RecipeFactory $recipeFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->recipeFactory = app(RecipeFactory::class);
    }

    /**
     * @test
     */
    public function es_testet_speichern_und_holen_eines_rezepts()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, 400),
            new Ingredient("Schmalz", 200, 400),
            new Ingredient("Milch", 200, 400),
            new Ingredient("Mehl", 200, 400),
        ]);
        $recipe = $this->recipeFactory->add_recipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            $ingredients
        );

        $this->assertEquals($this->test_user->id(), $recipe->author()->id());
        $this->assertEquals("Test Rezept", $recipe->title());
        $this->assertTrue(DietStyle::ALLES()->equals($recipe->dietStyle()));
        $this->assertTrue(Cuisine::DEUTSCH()->equals($recipe->cuisine()));
        $this->assertEquals(60, $recipe->timeToPrepare());
        $this->assertEquals(["name" => "Butter", "gramm" => 200, "kcal" => 400], $recipe->ingredients()->toArray()[0]);
    }
}

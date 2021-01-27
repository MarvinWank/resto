<?php


namespace factories;


use App\Daos\RecipeDao;
use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\SIUnit;

class RecipeFactoryTest extends \FactoryTestCase
{
    private RecipeFactory $recipeFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->recipeFactory = app(RecipeFactory::class);
    }

    public function tearDown(): void
    {
        /** @var RecipeDao $recipeDao */
        $recipeDao = app(RecipeDao::class);
        $recipeDao->deleteForUser($this->test_user);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function es_testet_speichern_und_holen_eines_rezepts()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
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
        $this->assertEquals(["name" => "Butter", "amount" => 200.0, "unit" => "g", "kcal" => 100], $recipe->ingredients()->toArray()[0]);
    }
}

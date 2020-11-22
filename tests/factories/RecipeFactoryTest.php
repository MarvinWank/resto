<?php


namespace factories;


use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;

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
        $recipe = $this->recipeFactory->add_recipe(
            $this->test_user,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            800,
            ["Butter", "Schmalz", "Milch", "Mehl"]
        );

        $this->assertEquals($this->test_user->getID(), $recipe->getAuthor()->getID());
        $this->assertEquals("Test Rezept", $recipe->getTitle());
        $this->assertTrue(DietStyle::ALLES()->equals($recipe->getDietStyle()));
        $this->assertTrue(Cuisine::DEUTSCH()->equals($recipe->getCuisine()));
        $this->assertEquals(60, $recipe->getTimeToPrepare());
        $this->assertEquals(["Butter", "Schmalz", "Milch", "Mehl"], $recipe->getIngredients());
    }
}

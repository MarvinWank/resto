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
            ["Butter", "Schmalz", "Milch", "Mehl"]
        );

        $this->assertEquals($this->test_user->getID(), $recipe->author()->getID());
        $this->assertEquals("Test Rezept", $recipe->title());
        $this->assertTrue(DietStyle::ALLES()->equals($recipe->dietStyle()));
        $this->assertTrue(Cuisine::DEUTSCH()->equals($recipe->cuisine()));
        $this->assertEquals(60, $recipe->timeToPrepapre());
        $this->assertEquals(["Butter", "Schmalz", "Milch", "Mehl"], $recipe->ingredients());
    }
}

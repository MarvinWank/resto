<?php


namespace api\recipe;


use ApiTestCase;
use App\Exceptions\RecipeNotFoundException;
use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\Recipe;
use App\Value\SIUnit;

class DeleteRecipeApiTest extends ApiTestCase
{
    private RecipeFactory $recipeFactory;
    private Recipe $testRecipe;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipeFactory = app(RecipeFactory::class);
        $this->testLogin();

        $this->testRecipe = $this->createRecipe();
    }

    /**
     * @test
     */
    public function itTestsSucessfullyDeletingRecipe()
    {
        $result = $this->apiPost("/recipes/delete", ["id" => $this->testRecipe->id()]);
        $response = $result->getBody()->getContents();
        $response = json_decode($response, true);

        $recipeId = $this->testRecipe->id();
        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Recipe with ID $recipeId was deleted", $response['message']);

        $this->expectException(RecipeNotFoundException::class);
        $this->recipeFactory->fromId($recipeId);
    }

    private function createRecipe(): Recipe
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);
        return $this->recipeFactory->addRecipe(
            $this->testUser,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            60,
            90,
            $ingredients,
            "Your add here"
        );
    }
}

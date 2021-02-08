<?php


namespace api;


use ApiTestCase;
use App\Daos\RecipeDao;
use App\Factories\RecipeFactory;
use App\Value\Ingredient;

class AddRecipeTestApiTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->testLogin();
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
    public function it_tests_adding_recipe()
    {
        $body = [
            "recipe" => [
                "title" => "Test Recipe",
                "dietStyle" => "alles",
                "cuisine" => "asiatisch",
                "timeToCook" => 60,
                "totalTime" => 90,
                "ingredients" => [
                    ["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400],
                    ["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400],
                ],
                "description" => "Your add here"
            ]
        ];
        $response = $this->apiPost("/recipes/add", $body);
        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);

        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test Recipe", $response['recipe']['title']);
        $this->assertEquals("ALLES", $response['recipe']['dietStyle']);
        $this->assertEquals("ASIATISCH", $response['recipe']['cuisine']);
        $this->assertEquals(60, $response['recipe']['timeToCook']);
        $this->assertEquals(90, $response['recipe']['totalTime']);
        $this->assertEquals(["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400], $response['recipe']['ingredients'][0]);
        $this->assertEquals(["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400], $response['recipe']['ingredients'][1]);
        $this->assertEquals("Your add here", $response['recipe']['description']);

    }
}

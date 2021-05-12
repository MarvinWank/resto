<?php


namespace api\recipe;


use ApiTestCase;
use App\Daos\RecipeDao;
use App\Value\Recipe;

class GetRecipeApiTest extends ApiTestCase
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
        $recipeDao->deleteForUser($this->testUser);
        parent::tearDown();
    }
    /**
     * @test
     */
    public function it_tests_get_all_recipes()
    {
        $body = [
            "recipe" => [
                "title" => "Test Recipe",
                "dietStyle" => "ALLES",
                "cuisine" => "ASIATISCH",
                "timeToCook" => 60,
                "totalTime" => 90,
                "ingredients" => [
                    ["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400],
                    ["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400],
                ],
                "description" => "Your add here"
            ]
        ];
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 2";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 3";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 4";
        $this->apiPost("/recipes/add", $body);

        $response = $this->apiPost("/recipes/all");

        $this->assertCount(4, $response['recipes']);
        $this->assertEquals("Test Recipe", $response['recipes'][0]['title']);
        $this->assertEquals("Test Recipe 2", $response['recipes'][1]['title']);
        $this->assertEquals("Test Recipe 3", $response['recipes'][2]['title']);
        $this->assertEquals("Test Recipe 4", $response['recipes'][3]['title']);
    }

    /**
     * @test
     */
    public function it_tests_get_top_recipes()
    {
        $body = [
            "recipe" => [
                "title" => "Test Recipe",
                "dietStyle" => "ALLES",
                "cuisine" => "ASIATISCH",
                "timeToCook" => 60,
                "totalTime" => 90,
                "ingredients" => [
                    ["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400],
                    ["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400],
                ],
                "description" => "Your add here"
            ]
        ];
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 2";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 3";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 4";
        $this->apiPost("/recipes/add", $body);

        $response = $this->apiPost("/recipes/top");

        $this->assertCount(3, $response['recipes']);
        $this->assertEquals("Test Recipe", $response['recipes'][0]['title']);
        $this->assertEquals("Test Recipe 2", $response['recipes'][1]['title']);
        $this->assertEquals("Test Recipe 3", $response['recipes'][2]['title']);
    }

    /**
     * @test
     */
    public function it_tests_get_recipe_by_id()
    {
        $body = [
            "recipe" => [
                "title" => "Test Recipe",
                "dietStyle" => "ALLES",
                "cuisine" => "ASIATISCH",
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
        $response = Recipe::fromArray($response['recipe']);

        $resultApi = $this->apiPost("/recipes/get_by_id", ["id" => $response->id() ]);
        $resultApi = Recipe::fromArray($resultApi['recipe']);

        $this->assertEquals($response, $resultApi);
    }
}

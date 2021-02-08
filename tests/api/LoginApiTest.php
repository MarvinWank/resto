<?php


namespace api;


use App\Daos\RecipeDao;
use App\Factories\RecipeFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\Recipe;
use App\Value\RecipeSet;
use App\Value\SIUnit;

class LoginApiTest extends \ApiTestCase
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
    public function test_login_with_correct_credentials_is_succesful()
    {
        $body = ["json" => [
            'email' => $this->test_user->email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/api/login', $body);
        $response = json_decode($response->getBody()->getContents(), true);
        $this->assertIsArray($response);
        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test User", $response['user']['name']);
        $this->assertEquals("test@test.de", $response['user']['email']);
        $this->assertArrayHasKey("apiKey", $response);
    }

    /**
     * @test
     */
    public function it_tests_get_top_recipes_on_login()
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
            90,
            $ingredients,
            "Your add here"
        );

        $body = ["json" => [
            'email' => $this->test_user->email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/api/login', $body);
        $response = json_decode($response->getBody()->getContents(), true);

        $recipes = RecipeSet::fromArray($response['topRecipes']);
        $this->assertEquals(1, $recipes->count());
        /** @var Recipe $recipe */
        $recipe = $recipes->toArray()[0];

        $this->assertEquals("Test Rezept", $recipe['title']);
    }
}

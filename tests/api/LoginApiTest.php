<?php


namespace api;


use App\Daos\RecipeDao;
use App\Factories\RecipeFactory;
use App\Factories\ShoppingListFactory;
use App\Value\Cuisine;
use App\Value\DietStyle;
use App\Value\Ingredient;
use App\Value\IngredientsSet;
use App\Value\Recipe;
use App\Value\RecipeSet;
use App\Value\ShoppingList;
use App\Value\SIUnit;
use App\Value\TypeOfDish;

class LoginApiTest extends \ApiTestCase
{

    private RecipeFactory $recipeFactory;
    private ShoppingListFactory $shoppingListFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipeFactory = app(RecipeFactory::class);
        $this->shoppingListFactory = app(ShoppingListFactory::class);
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
    public function test_login_with_correct_credentials_is_succesful()
    {
        $response = $this->login();

        $this->assertIsArray($response);
        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test User", $response['user']['name']);
        $this->assertEquals("test@test.de", $response['user']['email']);
        $this->assertArrayHasKey("apiKey", $response);
        $this->assertArrayHasKey("shoppingList", $response);
        $this->assertNotEquals("", $response['apiKey']);
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
        $recipe = $this->recipeFactory->addRecipe(
            $this->testUser,
            "Test Rezept",
            DietStyle::ALLES(),
            Cuisine::DEUTSCH(),
            TypeOfDish::HAUPTSPEISE(),
            60,
            90,
            $ingredients,
            "Your add here"
        );


        $response = $this->login();
        $recipes = RecipeSet::fromArray($response['topRecipes']);
        $this->assertEquals(1, $recipes->count());
        $recipe = $recipes->toArray()[0];

        $this->assertEquals("Test Rezept", $recipe['title']);
    }

    /**
     * @test
     */
    public function it_tests_login_with_api_key()
    {
        $this->testLogin();

        $result = $this->apiPost("/login_with_api_key", [
            "apiKey" => $this->apiKey
        ]);

        $this->assertEquals("ok", $result['status']);
        $this->assertEquals($this->testUser->toArray(), $result['user']);
        $this->assertEquals($this->apiKey, $result['apiKey']);
    }

    /** @test */
    public function it_tests_get_shopping_list_on_login()
    {
        $ingredients = IngredientsSet::fromArray([
            new Ingredient("Butter", 200, SIUnit::g(), 100),
            new Ingredient("Schmalz", 200, SIUnit::g(), 100),
            new Ingredient("Milch", 200, SIUnit::g(), 100),
            new Ingredient("Mehl", 200, SIUnit::g(), 100),
        ]);

        $this->shoppingListFactory->addItemsToShoppingList($this->testUser, $ingredients);
        $response = $this->testLogin();

        $this->assertArrayHasKey("shoppingList", $response);
        $shoppingList = ShoppingList::fromArray($response['shoppingList']);

        $this->assertEquals($ingredients->toArray(), $shoppingList->ingredients()->toArray());

        $this->shoppingListFactory->deleteShoppingList($shoppingList);
    }

    private function login(): array
    {
        $body = ["json" => [
            'email' => $this->testUser->email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/api/login', $body);
        return \Safe\json_decode($response->getBody()->getContents(), true);
    }
}

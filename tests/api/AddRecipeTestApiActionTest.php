<?php


namespace api;


use ApiActionTestCase;
use App\Value\Ingredient;

class AddRecipeTestApiActionTest extends ApiActionTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->testLogin();
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
                ]
            ]
        ];
        $response = $this->apiCall("/recipes/add", $body);
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
    }
}

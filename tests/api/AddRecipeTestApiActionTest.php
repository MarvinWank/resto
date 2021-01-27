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
            "title" => "Test Recipe",
            "dietStyle" => "ALLES",
            "cuisine" => "ASIATISCH",
            "timeToPrepare" => 60,
            "ingredients" => [
                ["name" => "Milch", "amount" => 200, "unit" => "gram", "kcal" => 400],
                ["name" => "Mehl", "amout" => 0.2, "unit" => "kg", "kcal" => 400],
            ]
        ];
        $response = $this->apiCall("/recipes/add", $body);
        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);

        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test Recipe", $response['recipe']['title']);
        $this->assertEquals("ALLES", $response['recipe']['dietStyle']);
        $this->assertEquals("ASIATISCH", $response['recipe']['cuisine']);
        $this->assertEquals(60, $response['recipe']['timeToPrepare']);
        $this->assertEquals(   ["name" => "Milch", "gramm" => 200, "kcal" => 400], $response['recipe']['ingredients'][0]);
        $this->assertEquals( ["name" => "Mehl", "gramm" => 200, "kcal" => 400], $response['recipe']['ingredients'][1]);
    }
}

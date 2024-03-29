<?php


namespace api\recipe;


use ApiTestCase;

class AddRecipeTestApiTest extends ApiTestCase
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
                "dietStyle" => "ALLES",
                "cuisine" => "ASIATISCH",
                "typeOfDish" => "HAUPTSPEISE",
                "timeToCook" => 60,
                "totalTime" => 90,
                "ingredients" => [
                    ["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400],
                    ["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400],
                    ["name" => "Paprika", "amount" => 1, "unit" => "TL", "kcal" => 400],
                    ["name" => "Zimt", "amount" => 1, "unit" => "EL", "kcal" => 400],
                ],
                "description" => "Your add here"
            ]
        ];
        $response = $this->apiPost("/recipes/add", $body);



        $this->assertEquals("ok", $response['status']);

        $this->assertCount(10, $response['recipe']);
        $this->assertEquals("Test Recipe", $response['recipe']['title']);
        $this->assertEquals("ALLES", $response['recipe']['dietStyle']);
        $this->assertEquals("ASIATISCH", $response['recipe']['cuisine']);
        $this->assertEquals("HAUPTSPEISE", $response['recipe']['typeOfDish']);
        $this->assertEquals(60, $response['recipe']['timeToCook']);
        $this->assertEquals(90, $response['recipe']['totalTime']);
        $this->assertEquals(["name" => "Milch", "amount" => 200, "unit" => "g", "kcal" => 400], $response['recipe']['ingredients'][0]);
        $this->assertEquals(["name" => "Mehl", "amount" => 0.2, "unit" => "kg", "kcal" => 400], $response['recipe']['ingredients'][1]);
        $this->assertEquals(["name" => "Paprika", "amount" => 1, "unit" => "TL", "kcal" => 400], $response['recipe']['ingredients'][2]);
        $this->assertEquals(["name" => "Zimt", "amount" => 1, "unit" => "EL", "kcal" => 400], $response['recipe']['ingredients'][3]);
        $this->assertEquals("Your add here", $response['recipe']['description']);

    }
}

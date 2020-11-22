<?php


namespace api;


use ApiActionTestCase;

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
            "ingredients" => ["Milch", "Mehl"]
        ];
        $response = $this->apiCall("/recipes/add", $body);
        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);

        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test Recipe", $response['recipe']['title']);
        $this->assertEquals("ALLES", $response['recipe']['dietStyle']);
        $this->assertEquals("ASIATISCH", $response['recipe']['cuisine']);
        $this->assertEquals(60, $response['recipe']['timeToPrepare']);
        $this->assertEquals("Milch", $response['recipe']['ingredients'][0]);
        $this->assertEquals("Mehl", $response['recipe']['ingredients'][1]);
    }
}

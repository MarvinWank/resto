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
            "dietStyle" => "OMNIVORE",
            "cuisine" => "ASIAN",
            "timeToPrepare" => 60,
            "ingredients" => ["Milch", "Mehl"]
        ];
        $reponse = $this->apiCall("/recipes/add", $body);
    }
}

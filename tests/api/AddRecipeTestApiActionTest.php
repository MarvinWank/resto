<?php


namespace api;


use ApiActionTestCase;

class AddRecipeTestApiActionTest extends ApiActionTestCase
{
    /**
     * @test
     */
    public function it_tests_adding_recipe()
    {
        $body = ["json" => [
            "title" => "Test Recipe",
            "dietStyle" => "OMNIVORE",
            "cuisine" => "ASIAN",
            "timeToPrepare" => 60,
            "ingredients" => ["Milch", "Mehl"]
        ]];
        $reponse = $this->client->post("/recipes/add", $body);
    }
}

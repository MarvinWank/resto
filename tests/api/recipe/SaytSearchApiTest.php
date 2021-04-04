<?php


namespace api\recipe;


class SaytSearchApiTest extends \ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->testLogin();

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
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 2";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Test Recipe 3";
        $this->apiPost("/recipes/add", $body);
        $body['recipe']['title'] = "Different Name";
        $this->apiPost("/recipes/add", $body);
    }


    /**
     * @test
     */
    public function it_tests_sucessfull_search()
    {
        $results = $this->apiPost("/recipes/search/sayt", ["search" => "Test Recipe"]);

    }

}

<?php


namespace api;


class LoginApiActionTest extends \ApiActionTestCase
{
    /**
     * @test
     */
    public function test_login_with_correct_credentials_is_succesful()
    {
        $body = ["json" => [
            'email' => $this->test_user->email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/login', $body);
        $response = json_decode($response->getBody()->getContents(), true);
        $this->assertIsArray($response);
        $this->assertEquals("ok", $response['status']);
        $this->assertEquals("Test User", $response['user']['name']);
        $this->assertEquals("test@test.de", $response['user']['email']);
        $this->assertArrayHasKey("apiKey", $response);
    }
}

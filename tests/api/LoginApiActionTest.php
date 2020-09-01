<?php


namespace api;


use GuzzleHttp\Client;

class LoginApiActionTest extends \ApiActionTestCase
{
    /**
     * @test
     */
    public function test_login_with_correct_credentials_is_succesful()
    {
        $body = ["json" => [
            'email' => $this->test_user->get_email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/login', $body);
    }
}

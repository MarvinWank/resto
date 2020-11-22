<?php


use GuzzleHttp\Client;

class ApiActionTestCase extends TestCase
{
    protected $client;
    protected string $apiKey;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client(['base_uri' => $this->get_base_url()]);
    }

    public function testLogin()
    {
        $body = ["json" => [
            'email' => $this->test_user->get_email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/login', $body)->getBody()->getContents();
        $response = json_decode($response, true);

        $this->apiKey = $response['apiKey'];
    }

    public function apiCall(string $url, array $json_body)
    {
        $json_body['apiKey'] = $this->apiKey;
        $body = ["json" => $json_body];
        return $this->client->post($url, $body);
    }

    private function get_base_url(): string
    {
        return env('APP_URL');
    }
}

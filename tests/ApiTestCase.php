<?php


use GuzzleHttp\Client;

class ApiTestCase extends TestCase
{
    protected $client;
    protected string $apiKey;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client(['base_uri' => $this->get_base_url()]);
    }

    public function testLogin()
    {
        $body = ["json" => [
            'email' => $this->testUser->email(),
            'password' => "test"
        ]];
        $response = $this->client->post('/api/login', $body)->getBody()->getContents();
        $response = json_decode($response, true);

        $this->assertEquals("ok", $response['status']);
        $this->apiKey = $response['apiKey'];
    }

    public function apiPost(string $url, array $json_body = [])
    {
        $json_body['apiKey'] = $this->apiKey;
        $body = ["json" => $json_body];
        return $this->client->post("/api".$url, $body);
    }

    public function apiGet(string $url)
    {
        $json_body = [];
        $json_body['apiKey'] = $this->apiKey;
        $body = ["json" => $json_body];
        return $this->client->get("/api".$url, $body);
    }

    private function get_base_url(): string
    {
        return env('APP_URL');
    }
}

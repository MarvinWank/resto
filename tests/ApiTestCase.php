<?php


use App\Value\User;
use GuzzleHttp\Client;

class ApiTestCase extends TestCase
{
    protected $client;
    protected User $testUser;
    protected string $apiKey;

    public function setUp(): void
    {
        parent::setUp();

        $this->testUser = $this->generateTestUser();
    }

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client(['base_uri' => $this->get_base_url()]);
    }

    public function testLogin(): array
    {
        $body = ["json" => [
            'email' => $this->testUser->email(),
            'password' => "test",
            'testRequest' => true
        ]];
        $response = $this->client->post('/api/login', $body)->getBody()->getContents();
        $response = \Safe\json_decode($response, true);

        $this->assertEquals("ok", $response['status']);
        $this->apiKey = $response['apiKey'];

        return $response;
    }

    public function apiPost(string $url, array $json_body = [])
    {
        $json_body['apiKey'] = $this->apiKey;
        $json_body['testRequest'] = true;

        $body = ["json" => $json_body];
        $response = $this->client->post("/api" . $url, $body);
        $response = $response->getBody()->getContents();
        return \Safe\json_decode($response, true);
    }

    public function apiGet(string $url, array $params = [])
    {
        $params['apiKey'] = $this->apiKey;
        $params['testRequest'] = true;

        $body = ["json" => $params];
        $response = $this->client->get("/api" . $url, $body);
        $response = $response->getBody()->getContents();
        return \Safe\json_decode($response, true);
    }

    private function get_base_url(): string
    {
        return env('APP_URL');
    }
}

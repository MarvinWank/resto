<?php


use GuzzleHttp\Client;

class ApiActionTestCase extends TestCase
{
    protected $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client(['base_uri' => $this->get_base_url()]);
    }


    private function get_base_url(): string
    {
        return env('APP_URL');
    }
}

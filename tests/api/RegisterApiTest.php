<?php


namespace api;


use ApiTestCase;
use App\Factories\UserFactory;

class RegisterApiTest extends ApiTestCase
{
    private UserFactory $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->userFactory = app(UserFactory::class);
    }

    public function it_tests_successful_registration()
    {
        $this->apiPost('/register', [
           "name" => "Test User",
           "email" => "testuser@test.com",
           "password" => "test"
        ]);
    }
}

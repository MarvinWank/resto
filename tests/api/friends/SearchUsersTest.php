<?php


namespace api\friends;


use ApiTestCase;

class SearchUsersTest extends ApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->testLogin();
    }

    /** @test */
    public function it_tests_find_user_by_email()
    {
        $user1 = $this->generateTestUser("test user", "find@it.com");
        $user2 = $this->generateTestUser("test user", "find@it24.com");
        $user3 = $this->generateTestUser("test user", "foo@it.com");

        $response = $this->apiGet('/friends/search', ["searchQuery" => "find@it"]);

        $this->assertEquals("ok", $response['status']);
        $this->assertCount(2, $response['users']);
    }

    /** @test */
    public function it_tests_find_user_by_name()
    {
        $this->generateTestUser("test user", "find@it.com");
        $this->generateTestUser("test user", "find@it24.com");
        $this->generateTestUser("foo user", "foo@it.com");

        $response = $this->apiGet('/friends/search', ["searchQuery" => "test"]);

        $this->assertEquals("ok", $response['status']);
        $this->assertCount(2, $response['users']);
    }
}

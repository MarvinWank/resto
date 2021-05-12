<?php


namespace api;


use ApiTestCase;
use App\Daos\UsersDao;
use App\Factories\UserFactory;
use App\Value\User;

class RegisterApiTest extends ApiTestCase
{
    private UserFactory $userFactory;
    private ?User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = null;
        $this->userFactory = app(UserFactory::class);
    }

    public function tearDown(): void
    {
        if ($this->user !== null){
            $daoUser = UsersDao::query()->find($this->user->id());
            $daoUser->delete();
        }
        parent::tearDown();
    }

    public function it_tests_successful_registration()
    {
        $this->apiPost('/register', [
           "name" => "Test User",
           "email" => "testuser@test.com",
           "password" => "test"
        ]);

        $this->user = $this->userFactory->fromAuth("testuser@test.com", "test");
        $this->assertNotNull($this->user);
        $this->assertEquals("Test User", $this->user->name());
    }
}

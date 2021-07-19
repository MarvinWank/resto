<?php


namespace factories;


use App\Daos\UsersDao;
use App\Factories\UserFactory;
use FactoryTestCase;

class UserFactoryTestCase extends FactoryTestCase
{
    /** @var UserFactory $userFactory */
    private $userFactory;
    /** @var UsersDao $usersDao */
    private $usersDao;

    public function setUp(): void
    {
        parent::setUp();

        $this->userFactory = app(UserFactory::class);
        $this->usersDao = app(UsersDao::class);
    }

    /**
     * @test
     */
    public function es_testet_erzeuge_neuen_user()
    {
        $user = $this->userFactory->addUser("Marvin Wank", "m.wank@test.de", "test");
        $dao_user = $this->usersDao->newQuery()->find($user->id());

        $this->assertEquals("Marvin Wank", $dao_user->getAttribute(UsersDao::PROPERTY_NAME));
        $this->assertEquals("m.wank@test.de", $dao_user->getAttribute(UsersDao::PROPERTY_EMAIL));

        $dao_user->delete();
    }

    /** @test */
    public function it_tests_finding_users_by_email()
    {
        $user1 = $this->generateTestUser();
        $user2 = $this->userFactory->addUser("Similar Email", "friend1@test.de", "test");
        $this->userFactory->addUser("Different Email", "foo@bar.de", "test");

        $results = $this->userFactory->searchUsersByEmail("@test.de");

        $this->assertEquals(2, $results->count());
        $this->assertTrue($results->contains($user1));
        $this->assertTrue($results->contains($user2));
    }

    /** @test */
    public function it_tests_adding_friends_to_user()
    {
        $user = $this->generateTestUser();
        $friend1 = $this->userFactory->addUser("Friend 1", "friend1@test.de", "test");
        $friend2 = $this->userFactory->addUser("Friend 2", "friend2@test.de", "test");

        $this->userFactory->addFriendToUser($user, $friend1);
        $this->userFactory->addFriendToUser($user, $friend2);

        $userWithFriends = $this->userFactory->fromId($user->id());

        $this->assertTrue($userWithFriends->friends()->contains($friend1->id()));
        $this->assertTrue($userWithFriends->friends()->contains($friend2->id()));
    }
}

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
        $user = $this->userFactory->add_user("Marvin Wank", "m.wank@test.de", "test");
        $dao_user = $this->usersDao->find($user->getID());
    }
}

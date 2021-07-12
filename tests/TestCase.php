<?php

use App\Factories\UserFactory;
use App\Value\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    /** @var UserFactory $userFactory */
    private $userFactory;
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->boot();
        return $app;
    }

    public function __construct()
    {
        parent::__construct();
        $this->createApplication();

        $this->userFactory = app(UserFactory::class);
    }

    public function generateTestUser(): User
    {
        return $this->userFactory->addUser(
            "Test User",
            "test@test.de",
            "test"
        );
    }
}

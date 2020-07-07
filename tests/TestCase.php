<?php

use App\Factories\UserFactory;
use App\Models\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var UserFactory $userFactory */
    private $userFactory;

    private $test_user;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function __construct()
    {
        parent::__construct();

        $this->userFactory = app(UserFactory::class);

        $this->create_test_user();
    }

    private function create_test_user(): User
    {
        return $this->userFactory->from_id(1);
    }
}

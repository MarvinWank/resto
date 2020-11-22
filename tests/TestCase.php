<?php

use App\Factories\UserFactory;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var UserFactory $userFactory */
    private $userFactory;

    protected $test_user;

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

        $this->test_user = $this->create_test_user();
    }

    private function create_test_user(): \App\Value\User
    {
        return $this->userFactory->from_id(1);
    }
}

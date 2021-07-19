<?php

use App\Daos\FriendshipDao;
use App\Daos\IngredientsDao;
use App\Daos\RecipeDao;
use App\Daos\ShoppingListDao;
use App\Daos\StateDao;
use App\Daos\StepsDao;
use App\Daos\UsersDao;
use App\Factories\UserFactory;
use App\Value\User;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /** @var UserFactory $userFactory */
    private $userFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->truncateTables();
        \Safe\touch("testsRunning");
    }

    public function tearDown(): void
    {
        \Safe\unlink("testsRunning");
        parent::tearDown();
    }

    private function truncateTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FriendshipDao::query()->truncate();
        IngredientsDao::query()->truncate();
        RecipeDao::query()->truncate();
        ShoppingListDao::query()->truncate();
        StateDao::query()->truncate();
        StepsDao::query()->truncate();
        UsersDao::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->boot();
        return $app;
    }

    public function __construct()
    {
        parent::__construct();
        $this->createApplication();

        $this->userFactory = app(UserFactory::class);
    }

    public function generateTestUser(string $username = "Test User", string $email = "test@test.de", string $password = "test"): User
    {
        return $this->userFactory->addUser(
            $username,
            $email,
            $password
        );
    }
}

<?php


namespace App\Factories;


use App\Daos\UsersDao;
use App\Models\User;

class UserFactory
{
    /** @var UsersDao $usersDao */
    private $usersDao;


    public function __construct(UsersDao $usersDao)
    {
        $this->usersDao = $usersDao;
    }

    public function from_id(int $id): User
    {
        $dao_user = $this->usersDao->get_user_by_id($id);
        $name = $dao_user->get('name');
        $email = $dao_user->get('email');

        return new User($name, $email);
    }

    public function add_user(string $name, string $email, string $pasword): User
    {
        $user = new User($name, $email);
        return $this->from_id($this->usersDao->insert_user($user, $pasword));
    }
}

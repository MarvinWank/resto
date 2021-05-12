<?php


namespace App\Factories;


use App\Daos\UsersDao;
use App\Models\State;
use App\Value\User;
use Illuminate\Http\Request;

class UserFactory
{
    private UsersDao $usersDao;
    private Request $request;
    private State $state;

    public function __construct(UsersDao $usersDao, Request $request, State $state)
    {
        $this->usersDao = $usersDao;
        $this->request = $request;
        $this->state = $state;
    }

    public function currentUser(): User
    {
        return  $this->fromId($this->state->getUserID());
    }

    public function fromId(int $id): User
    {
        $dao_user = $this->usersDao->get_user_by_id($id);
        return $this->fromDao($dao_user);
    }

    //TODO better exception Handling
    public function fromAuth(string $email, string $password): ?User
    {
        try{
            $dao_user = $this->usersDao->get_user_by_email($email);
        }catch (\Throwable $exception){
            //Email existiert nicht
            return null;
        }
        //Passwort war falsch
        if (!$this->usersDao->validate_auth($email, $password)) {
            return null;
        }

        $user = $this->fromDao($dao_user);
        $this->state->setUserID($user->id());

        return $user;
    }

    /**
     * @throws \Throwable
     */
    public function addUser(string $name, string $email, string $pasword): User
    {
        $this->usersDao = new UsersDao();
        $this->usersDao->setAttribute(UsersDao::PROPERTY_NAME, $name);
        $this->usersDao->setAttribute(UsersDao::PROPERTY_EMAIL, $email);
        $this->usersDao->setAttribute(UsersDao::PROPERTY_PASSWORD, $pasword);
        $this->usersDao->saveOrFail();

        return $this->fromDao($this->usersDao);
    }

    private function fromDao(UsersDao $dao_user): User
    {
        $id = $dao_user->getAttribute(UsersDao::PROPERTY_ID);
        $email = $dao_user->getAttribute(UsersDao::PROPERTY_EMAIL);
        $name = $dao_user->getAttribute(UsersDao::PROPERTY_NAME);

        return new User($id, $name, $email);
    }
}

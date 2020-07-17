<?php


namespace App\Factories;


use App\Daos\UsersDao;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserFactory
{
    /** @var UsersDao $usersDao */
    private $usersDao;
    /**
     * @var Request
     */
    private $request;


    public function __construct(UsersDao $usersDao, Request $request)
    {
        $this->usersDao = $usersDao;
        $this->request = $request;
    }

    public function current_user(): User
    {
        return  $this->from_id($this->request->session()->get('current_user'));
    }

    public function from_id(int $id): User
    {
        $dao_user = $this->usersDao->get_user_by_id($id);
        return $this->user_from_dao($dao_user);
    }

    public function from_auth(string $email, string $password): ?User
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
        $this->request->session()->put('current_user', $dao_user->getAttribute('id') );
        return $this->user_from_dao($dao_user);
    }

    public function add_user(string $name, string $email, string $pasword): User
    {
        $user = new User($name, $email);
        return $this->from_id($this->usersDao->insert_user($user, $pasword));
    }

    private function user_from_dao(UsersDao $dao_user): User
    {
        $name = $dao_user->getAttribute('name');
        $email = $dao_user->getAttribute('email');

        return new User($name, $email);
    }
}
